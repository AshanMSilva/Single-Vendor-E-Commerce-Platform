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
SELECT * from couriers NATURAL JOIN (SELECT * FROM orders NATURAL JOIN (payments NATURAL join deliveries as t) WHERE orders.order_id=12)as k 





--to make the order details table need the varient(product) | name | price | quantity |
SELECT title , price , quantity FROM products natural join variants as t JOIN order_details on order_details.product_id = t.product_id and order_details.variant_id=t.variant_id WHERE order_details.order_id = 3 
