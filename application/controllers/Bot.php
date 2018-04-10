<?php 

class Bot extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'html', 'form'));
        $this->load->library(array('session', 'form_validation', '../core/input'));
        $this->load->database();
        $this->load->model(array('user_model', 'antrian_model'));
        define('TOKEN','314241469:AAHjKybokLR7b_nLIXwDQiccIEos5UITMtE');
    }

	function BotKirim($perintah)
	{
  		return 'https://api.telegram.org/bot'.TOKEN.'/'.$perintah;
	}

	function KirimPerintahStream($perintah,$data)
	{
	   $options = array(
	      'http' => array(
	          'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
	          'method'  => 'POST',
	          'content' => http_build_query($data),
	      ),
		);
	  	$context  = stream_context_create($options);
	  	$result = file_get_contents(BotKirim($perintah), false, $context);
	  	return $result;
	}

	function KirimPerintahCurl($perintah,$data)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,BotKirim($perintah));
		curl_setopt($ch, CURLOPT_POST, count($data));
		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$kembali = curl_exec ($ch);
		curl_close ($ch);

		return $kembali;
	}

	function DapatkanUpdate($offset) 
	{
		$url = BotKirim("getUpdates")."?offset=".$offset;
		$kirim = file_get_contents($url);
		$hasil = json_decode($kirim, true);
		if ($hasil["ok"]==1) {
		    return $hasil["result"];
		}
		else {
		    return array();
		}
	}

	function KirimPerintah($perintah,$data)
	{
    	if(is_callable('curl_init')) {
	       	$hasil = KirimPerintahCurl($perintah,$data);
	        
	        if (empty($hasil)) {
	            $hasil = KirimPerintahStream($perintah,$data);
	        }   
      	}
      	else {
        	 $hasil = KirimPerintahStream($perintah,$data);
        }
     	return $hasil;         
 	}

 	function JalankanBot()
 	{
      	$update_id  = 0;
      	if (file_exists("last_update_id")) {
        	$update_id = (int)file_get_contents("last_update_id");
      	}
      	
      	$updates = DapatkanUpdate($update_id);
              
      	foreach ($updates as $message) 
      	{
	        $update_id = $message["update_id"];;
	        $message_data = $message["message"];
	          
	        //jika terdapat text dari Pengirim
	         if (isset($message_data["text"])) {
	            $chatid = $message_data["chat"]["id"];
	            $message_id = $message_data["message_id"];
	            $text = $message_data["text"];
	            
	            $data = array(
	                'chat_id' => $chatid,
	                'text'=> 'tes balas halo',
	                'parse_mode'=>'Markdown',
	                'reply_to_message_id' => $message_id
	            );
	            
	           $hasil = KirimPerintah('sendMessage',$data);
        	}     
    	}
      //tulis dan tandai updatenya yang nanti digunakan untuk nilai offset
      	file_put_contents("last_update_id", $update_id + 1);
	}

	function kirim_notif()
	{ 
	    $message = "
	Monitoring Jaringan 
	=============
	IP: <b></b>
	HOST: <b></b>
	STATUS: <b></b>
	";

	    $data = array(
	                'chat_id' => 242464619,
	                'text'=> $message,
	                'parse_mode'=>'HTML',
	            );

	  	KirimPerintah('sendMessage', $data);
	}

	public function index() 
    {
    	$jeda = 5;
		if(php_sapi_name()==="cli") {
        	sleep($jeda); //beri jedah 2 detik
  		} else {
        	echo '<meta http-equiv="refresh" content="'.$jeda.'">';
        	echo base_url('application/views/bot.php');
        	echo '<br><br>Bot sedang jalan';
  		}
    }
}