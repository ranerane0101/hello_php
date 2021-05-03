<?php

//セッションの開始
session_start();
echo "<h1>宝探し</h1>";
echo "<p>マップ上の適当な場所をクリック！</p>";
//ゲーム状態を確認する
$stat = $_SESSION['stat'];
if(!$stat || $_GET['m'] == "reset")
{
  init_game();
  draw_map();
  exit;
}
//when panels would open
if($_GET['m'] = 'click')
{
  click_panel();
}
//game palameter starts
function init_game()
{
//ゲームの初期化
  $_SESSION['stat']    =    'playing';
  $_SESSION['turn']    =    0;
  //treasure returns
  $_SESSION['treasure_x'] = rand(0,8);
  $_SESSION['treasure_y'] = rand(0,8);
  //maps returns
  for($y = 0; $y < 9; $y++){
    for($x = 0; $x < 9; $x++){
      $_SESSION['map'][$y][$x] ="*";
    }

  }

}
//Map draws
function draw_map()
{
  $map = $_SESSION['map'];
  $s = "<table border='1'>";
  for($y = 0; $y < 9; $y++)
  {
    $s .= "<tr>";
    for($x = 0; $x < 9; $x++)
    {
      $v = $_SESSION["map"][$y][$x];
      $color = "#FFFFFF";
      if($v == "*")
      {
        $v = "<a href='?m=click&x=$x$y&y=$y'>*</a>";
        $color = "#C0C0C0";
      }
      $s .="<td width='24' aligh='center'bgcolor='$color'>";
      $s .="$v</td>";
    }
    $s .= "</tr>";
  }
  $s .= "</table>";
  echo $s;
  echo "<p>今は、{$_SESSION['turn']}手目です。</p>";
  echo "<p><a href='?m=reset'>*Restart*</a></p>";
}
//When panels is clicked
function click_panel()
{
  $x = intval($_GET['x']);
  $y = intval($_GET['y']);
  $treasure_x = $_SESSION['treasure_x'];
  $treasure_y = $_SESSION['treasure_y'];
  $_SESSION['turn']++;
  //宝を見つけたか判定する
  if($treasure_x == $x && $treasure_y == $y){
    //宝を見つけた場合
    $_SESSION['map'][$y][$x] = '<font color="red">@</font>';
    echo '<h1>大当たり！</h1>';
    draw_map();
    init_game();
    exit;
  }else{
    //間違えた場合宝までの距離を示す
    $dist = abs($treasure_x - $x) + abs($treasure_y - $y);
    $_SESSION['map'][$y][$x] = $dist;
    echo "<p>惜しい！　あと$dist の距離のところ</p>";
    draw_map();
    exit;
  }
}

?>
