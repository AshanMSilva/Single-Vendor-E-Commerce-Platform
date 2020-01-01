<?php

class Order extends Model{
    private $order_id, $order_date, $customer_id;

    public function __construct($details){
        parent::__construct();
        foreach($details as $key => $val){            
            $this->$key = $val;
        }
    }

    public static function create_order($cart, $cust_id){
        $db = DB::getInstance();
        $date = date("Y-m-d");
        $id = $db->insert('orders', [
            'order_date' => $date,
            'customer_id' => $cust_id
        ]);

        foreach($cart as $product){
            $db->insert('order_details', [
                'order_id' => $id,
                'product_id' => $product['product_id'],
                'variant_id' => $product['variant_id'],
                'quantity' => $product['quantity']
            ]);
        }
        $details = [];
        $details['order_id'] = $id;
        $details['order_date'] = $date;
        $details['customer_id'] = $cust_id;
        $order_obj = new Order($details);
        return $order_obj;
    }

    public function create_payment($method, $amount, $card){
        parent::set_table_name('payments');
        parent::insert([
            'order_id' => $this->order_id,
            'payment_method' => $method,
            'amount' => $amount,
            'card_number' => $card
        ]);
    }

    public static function start_order_transaction($cart, $cust_id, $payment, $details, $address = []){
        $db = DB::getInstance();
        $pdo = $db->get_pdo();
        // dnd($pdo);
        try{
            $pdo->beginTransaction();
            $date = date("Y-m-d");

            $sql = "INSERT INTO `orders` (`order_date`, `customer_id`) VALUES (?,?)";
            $stmt = $pdo->prepare($sql);
            $params = [$date, $cust_id];
            $x = 1; 
			if(count($params)){
				foreach($params as $p){
					$stmt->bindValue($x, $p);
					$x++;
				}
            }
            // dnd($stmt);
            $stmt->execute();
            $stmt->closeCursor();
            $order_id = $pdo->lastInsertID();

            foreach($cart as $product){
                $sql = "INSERT INTO `order_details` (`order_id`, `product_id`, `variant_id`, `quantity`) VALUES (?,?,?,?)";
                $stmt = $pdo->prepare($sql);
                $params = [$order_id, $product['product_id'], $product['variant_id'], $product['quantity']];
                // echo($product['variant_id']);
                $x = 1;
                if(count($params)){
                    foreach($params as $p){
                        $stmt->bindValue($x, $p);
                        $x++;
                    }
                }
                $stmt->execute();
                $stmt->closeCursor();
            }

            $tracking_id = uniqid() . "_" . rand(100000, 999999);
            // dnd($tracking_id);
            if(array_key_exists('estimated_date', $details)){
                $fieldString = '`order_id`, `delivery_method`, `tracking_info`, ';
                $valueString = '?,?,?,';
                $params = [$order_id, 'delivery', $tracking_id];

                foreach($details as $field => $value){
                    $fieldString .= '`' . $field . '`, ';
                    $valueString .= '?,';
                    $params[] = $value;
                }
                foreach($address as $field => $value){
                    $fieldString .= '`' . $field . '`, ';
                    $valueString .= '?,';
                    $params[] = $value;
                }
                $fieldString = rtrim($fieldString, ', ');
                $valueString = rtrim($valueString, ',');
                
                $sql = "INSERT INTO `deliveries` ({$fieldString}) VALUES ({$valueString})";
                /*$sql = "INSERT INTO `deliveries`  
                (`order_id`, `delivery_method`, `tracking_info`, `estimated_date`, `customer_contact`, `house_number`, `street`, `city`, `state`, `zip_code`) 
                VALUES (?,?,?,?,?,?,?,?,?,?)";*/
            }
            else{
                $fieldString = '`order_id`, `delivery_method`, `tracking_info`, `estimated_date`, `customer_contact`';
                $valueString = '?,?,?,?,?';
                $params = [$order_id, 'store_pickup', $tracking_id, $details['available_date'], $details['customer_contact']];
                
                $sql = "INSERT INTO `deliveries` ({$fieldString}) VALUES ({$valueString})";
            }
            $stmt = $pdo->prepare($sql);
            $x = 1;
            if(count($params)){
                foreach($params as $p){
                    $stmt->bindValue($x, $p);
                    $x++;
                }
            }
            $stmt->execute();
            $stmt->closeCursor();

            $sql = "INSERT INTO `payments` (`order_id`, `payment_method`, `amount`, `card_number`) VALUES (?,?,?,?)";
            $stmt = $pdo->prepare($sql);
            $params = [$order_id, $payment[0], $payment[1], $payment[2]];
            $x = 1;
            if(count($params)){
                foreach($params as $p){
                    $stmt->bindValue($x, $p);
                    $x++;
                }
            }
            $stmt->execute();
            
            $pdo->commit();
            $return_data = [$order_id, $date, $tracking_id];
            return $return_data;
        }
        catch (PDOException $e) {
            $pdo->rollBack();
            return $e->getMessage();
        }
    }

    public function get_order_id(){
        return $this->order_id;
    }
}