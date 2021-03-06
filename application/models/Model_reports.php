<?php 

class Model_reports extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*getting the total months 
	private function months()
	{
		return array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12','01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
	}

	/* getting the year of the orders 
	public function getOrderYear()
	{
		$sql = "SELECT * FROM orders WHERE paid_status = ?";
		$query = $this->db->query($sql, array(1));
		$result = $query->result_array();
		
		$return_data = array();
		foreach ($result as $k => $v) {
			$date = date('d', $v['date_time']);
			$return_data[] = $date;
		}

		$return_data = array_unique($return_data);

		return $return_data;
	}

	// getting the order reports based on the year and moths 
	public function getOrderData($year)
	{	
		if($year) {
			$months = $this->months();
			
			$sql = "SELECT * FROM orders WHERE paid_status = ?";
			$query = $this->db->query($sql, array(1));
			$result = $query->result_array();

			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year.'-'.$month_y;	

				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					$month_year = date('Y-m-d', $v['date_time']);

					if($get_mon_year == $month_year) {
						$final_data[$get_mon_year][] = $v;
					}
				}
			}	


			return $final_data;
			
		}
	} 

	/*getting the total months */
	private function daily()
	{
		return array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12','01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
	}

	/* getting the year of the orders */
	public function getOrderDaily()
	{
		$sql = "SELECT * FROM orders WHERE paid_status = ?";
		$query = $this->db->query($sql, array(1));
		$result = $query->result_array();
		
		$return_data = array();
		foreach ($result as $k => $v) {
			$date = date('d', $v['date_time']);
			$return_data[] = $date;
		}

		$return_data = array_unique($return_data);

		return $return_data;
	}

	// getting the order reports based on the daily and moths
	public function getOrderData($month)
	{	
		if($month) {
			$daily = $this->daily();
			
			$sql = "SELECT * FROM orders WHERE paid_status = ?";
			$query = $this->db->query($sql, array(1));
			$result = $query->result_array();

			$final_data = array();
			foreach ($daily as $daily_k => $daily_d) {
				$get_daily = $month.'-'.$daily_d;	 

				$final_data[$get_daily][] = '';
				foreach ($result as $k => $v) {
					$daily_day = date('d', $v['date_time']);

					if($get_daily == $daily_day) {
						$final_data[$get_daily][] = $v;
					}
				}
			}


			return $final_data;
			
		} 
	}
	public function getOrderDailyPaid()
	{
		
		$start_date = date("Y-m-d H:i:s", mktime(0,0,0)); 
		$end_date   = date("Y-m-d H:i:s", mktime(23,59,59));

		$sql  = 'SELECT products.name,orders.customer_name,SUM(orders.net_amount)as amount  FROM orders  
				LEFT JOIN orders_item ON orders.id = orders_item.order_id  
				LEFT JOIN  products ON orders_item.product_id =products.id 
				WHERE paid_status=? AND date_time >=? AND date_time <=? 
				GROUP BY products.name,orders.customer_name ';

		$query  = $this->db->query($sql, array(1,$start_date,$end_date));

		return $query->result_array();

	
	}
}