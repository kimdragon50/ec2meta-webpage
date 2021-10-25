<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
$curl_cmd = 'curl --connect-timeout 1';
$meta_host = '169.254.169.254';
$meta_data['ami-id 정보'] = $ami_id = exec($curl_cmd." http://".$meta_host."/latest/meta-data/ami-id/");
$meta_data['instance-id 정보'] = $instance_id = exec($curl_cmd." http://".$meta_host."/latest/meta-data/instance-id/");
$meta_data['instance 종류'] = $instance_id = exec($curl_cmd." http://".$meta_host."/latest/meta-data/instance-type/");
$meta_data['가용영역 정보'] = $reg_az = exec($curl_cmd." http://".$meta_host."/latest/meta-data/placement/availability-zone/");
$meta_data['퍼블릭 호스트네임'] = $public_hostname = exec($curl_cmd." http://".$meta_host."/latest/meta-data/public-hostname/");
$meta_data['공인 IP 주소'] = $public_ipv4 = exec($curl_cmd." http://".$meta_host."/latest/meta-data/public-ipv4/");
$meta_data['로컬 호스트네임'] = $local_hostname = exec($curl_cmd." http://".$meta_host."/latest/meta-data/local-hostname/");
$meta_data['로컬 IP 주소'] = $local_ipv4 = exec($curl_cmd." http://".$meta_host."/latest/meta-data/local-ipv4/");
$meta_data['보안그룹'] = $local_ipv4 = exec($curl_cmd." http://".$meta_host."/latest/meta-data/security-groups/");
$server_name = $_SERVER['SERVER_NAME'];
$server_ip = $meta_data['공인 IP 주소'];
$server_software = $_SERVER['SERVER_SOFTWARE'];
$client_ip = $_SERVER['REMOTE_ADDR'];
$client_agent = $_SERVER['HTTP_USER_AGENT'];
$page_title =  'AWS Cloud - ' . $server_name;
$php_self = $_SERVER['SCRIPT_NAME'];
/** find the availability zone **/
 function findAZ ($az) {
	// check if the value is null/empty
	if (empty($az) || !isset($az)) {
	return 'Error: unknown az';
	}
	$az = strtolower($az);
	return $az;
 } //end function

 /** find the region **/
 function findRegion ($region) {
 	// check if the value is null/empty
	if (empty($region) || !isset($region)) {
	return 'Error: unknown region';
	}
	$region = substr($region, 0,-1);
	$region = strtoupper($region);
	return $region;
 } //end function

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>AWS EC2 Meta Data</title>
	<style type="text/css" media="all">@import "css/master.css";</style>
</head>

<body class="about">
<div id="box">
	<div id="header">
		<div id="logo">
			<h1>AWS EC2 서버 정보</h1>
		</div>
    </div>
    <div id="right">
		<div class="padding">
			<h2>AWS 리전정보 </h2>
			<p><?php echo findRegion($meta_data['가용영역 정보']); ?></p><br>
			<h3>가용영역 정보</h3>
			<p><?php echo findAZ($meta_data['가용영역 정보']); ?></p><br>
			<h3>서버/클라이언트 접속 정보</h3>
			<p>Server: <?php echo $server_software.'<br>Public IP: ';?><a href="http://<?php echo $server_ip; ?>"><?php echo $server_ip; ?></a></p>
			<p>Client: <?php echo $client_agent.'<br>IP: '.$client_ip; ?></p>
		</div>
	</div> <!-- End sidebar-a -->

	<div id="left">
		<div class="padding" style="font-size:11pt;">
			<h2>EC2 Metadata 정보</h2>
			<?php
			    //metadata table
			    echo '<table border="0" bgcolor="#ffffff" cellpadding="5" cellspacing="0" width="100%">';
			    echo '<tr><th align="left">Metadata</th><th align="left">Value</th></tr>';
			    foreach($meta_data as $x=>$x_value) {
			       echo '<tr>';
			    	echo '<td nowrap><span class="key">'. $x . '</span></td>';
			            echo '<td no wrap><span class="value">'. $x_value . '</span></td>';
			       echo '</tr>';
			    }
			    echo '</table>';
		        ?>
		</div>
	</div> <!-- End left -->

	<div id="downbar">
		<div id="altnav">
			<h2> EC2 Meta Data 기반 정보를 출력한 내용입니다.</h2>
		</div>
	</div> <!-- End downbar -->

</div> <!-- End Page Container -->
</body>
</html>