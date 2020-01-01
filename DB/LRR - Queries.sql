--get all orders by customer id : not deleted
--customer id is a variable
SELECT * FROM `orders` WHERE `customer_id`=3 and `deleted`=0;

--get order amount and payment method
--order_id is a variable
SELECT `order_id`,`payment_method`,`amount` FROM `payments` WHERE `order_id`=3;

--get all the info for an order
--order_id is variable
SELECT * FROM orders LEFT OUTER JOIN (payments NATURAL join deliveries as t) on t.order_id=orders.order_id WHERE orders.order_id=12



--on the all orders page need | order id | order date | status | current location |
SELECT orders.order_id,orders.order_date,amount,t.status,t.tracking_info FROM orders LEFT OUTER JOIN (payments NATURAL join deliveries as t) on t.order_id=orders.order_id WHERE orders.customer_id=3



--to fill the order info part need |order_id | order_date | amount | payment_method`|
--delivery info Courier_ID,Courier_name,Courier email,delivery method, 
--shipping info house No, street , city, State , zip_code
--estimated date
--status
--tracking_info
SELECT * FROM orders WHERE order_id=4;
SELECT * FROM payments WHERE order_id=4;
SELECT * FROM deliveries NATURAL JOIN couriers WHERE order_id=4;
--join these o_id is in param
------------------------get_order_info
SELECT orders.order_id as order_id, order_date, customer_id, deleted, payment_method, amount, card_number, courier_id, delivery_method, tracking_info, estimated_date, completed_date, status, customer_contact, house_number, street, city, state, last_name, zip_code, email, first_name FROM orders left join payments on orders.order_id=payments.order_id left JOIN (SELECT * FROM deliveries NATURAL JOIN couriers) as t on orders.order_id=t.order_id WHERE orders.order_id=o_id

------------------------get_undelete_orders
SELECT orders.order_id,orders.order_date,amount,t.status,t.tracking_info FROM orders LEFT OUTER JOIN (payments NATURAL join deliveries as t) on t.order_id=orders.order_id WHERE orders.customer_id=user_id and `deleted`=0




--to make the order details table need the varient(product) | name | price | quantity |
SELECT title , price , quantity FROM products natural join variants as t JOIN order_details on order_details.product_id = t.product_id and order_details.variant_id=t.variant_id WHERE order_details.order_id = 3 



---------------------3months 
--input year
--take by 3 months
--columns  
-- | item | Q1 | Q2 | Q3 | Q4 | total 

SELECT order_id, order_date ,Q , k.product_id as product_id,k.variant_id as variant_id, quantity, price ,quantity*price as total, SUM(quantity*price) as product_total FROM (SELECT * FROM (SELECT order_id as id, order_date,Quarter(`order_date`)as Q FROM `orders` WHERE YEAR(`order_date`)='2019')as t JOIN `order_details` on t.id = order_details.order_id) as k JOIN variants on k.variant_id = variants.variant_id GROUP BY product_id





----------------------------------------------------------------------------------------------------------------------------


------------------------get_order_info
SELECT orders.order_id as order_id, order_date, customer_id, deleted, payment_method, amount, card_number, courier_id, delivery_method, tracking_info, estimated_date, completed_date, status, customer_contact, house_number, street, city, state, last_name, zip_code, email, first_name FROM orders left join payments on orders.order_id=payments.order_id left JOIN (SELECT * FROM deliveries NATURAL JOIN couriers) as t on orders.order_id=t.order_id WHERE orders.order_id=o_id

------------------------get_undelete_orders
SELECT orders.order_id,orders.order_date,amount,t.status,t.tracking_info FROM orders LEFT OUTER JOIN (payments NATURAL join deliveries as t) on t.order_id=orders.order_id WHERE orders.customer_id=user_id and `deleted`=0

------------------------get_products_of_order
SELECT title , price , quantity FROM products natural join variants as t JOIN order_details on order_details.product_id = t.product_id and order_details.variant_id=t.variant_id WHERE order_details.order_id = o_id
