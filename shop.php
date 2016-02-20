<?php
/**
 *
 * 1、按照要求创建记账系统表，并添加信息
 *
 * 2、编写展示页面
 *
 * 3、页面信息需要两表联查
 *
 * 4、对同一类型的多条消费记录进行分组求和
 *
 * 5、求出消费总金额，对每个消费类型的总金额进行对比，求出百多比
 *
 * 6、数据准确后展示列表
 * */
header ("content-type:text/html;charset=utf8");
$dsn = "mysql:host=localhost;dbname=open";
$db = new PDO($dsn, 'root', '1314');

//求出总消费金额
$sql1="SELECT sum(m_money)as amount FROM detailed ";
$res=$db->query($sql1);
$arr1= $res->fetchAll(PDO::FETCH_ASSOC)[0];
$amount=$arr1['amount'];

//两表联查求出每种消费类型的总金额
$sql="SELECT sum(m_money)as money,shop_type FROM detailed INNER JOIN shoptype ON detailed.shop_id=shoptype.shop_id GROUP BY shop_type";
$re=$db->query($sql);
$arr= $re->fetchAll(PDO::FETCH_ASSOC);

//print_r($arr);die;
echo "<h1>记账系统</h1>";
echo "<table border='1'>";
echo "<th>消费类型</th><th>消费总金额</th><th>百分比</th>";
foreach($arr as $k=>$v){
    echo "<tr>";
    echo "<td>".$v['shop_type']."</td>";
    echo "<td>".$v['money']."</td>";
    $money=round($v['money']/$amount*100);
//    echo $money;
    echo "<td>".$money."%"."</td>";
    echo "</tr>";
}
echo "</table>";
?>
