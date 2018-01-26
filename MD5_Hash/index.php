<!DOCTYPE html>
<head><title>Nan Deng MD5 Cracker</title></head>
<body>
<h1>MD5 cracker</h1>
<p>This application takes an MD5 hash of a four digit pin and
check all 10,000 possible four digit PINs to determine the PIN.</p>
<pre>
Debug Output:
<?php
$goodtext = "Not found";
// If there is no parameter, this code is all skipped
if ( isset($_GET['md5']) ) {
    $time_pre = microtime(true);
    $md5 = $_GET['md5'];

    $num = "0123456789";
    $show = 15;
    $count = 0;

    for($i=0; $i<strlen($num); $i++ ) {
        $ch1 = $num[$i];
        for($j=0; $j<strlen($num); $j++ ) {
            $ch2 = $num[$j];
            for($m=0; $m<strlen($num); $m++ ){
                $ch3 = $num[$m];
                for($n=0; $n<strlen($num); $n++ ) {
                    $ch4 = $num[$n];

                    $try = strval($ch1.$ch2.$ch3.$ch4);
                    $count += 1;
                    $check = hash('md5', $try);
                    if ( $check == $md5 ) {
                        $goodtext = $try;
                        break;
                    }

                    // 15 sample Debug output
                    if ( $show > 0 ) {
                        print "$check $try\n";
                        $show = $show - 1;
                    }
                }
            }
        }
    }
    // Show total checks
    print "Total checks: ";
    print $count;
    print "\n";

    // Compute ellapsed time
    $time_post = microtime(true);
    print "Ellapsed time: ";
    print $time_post-$time_pre;
    print "\n";
}
?>
</pre>
<!-- Use the very short syntax and call htmlentities() -->
<p>PIN: <?= htmlentities($goodtext); ?></p>
<form>
<input type="text" name="md5" size="60" />
<input type="submit" value="Crack MD5"/>
</form>
<ul>
<li><a href="index.php">Reset</a></li>
<li><a href="md5.php">MD5 Encoder</a></li>
<li><a href="makecode.php">MD5 Code Maker</a></li>
<li><a href="https://github.com/csev/wa4e/tree/master/code/crack" target="_blank">Source code for this application</a></li>
</ul>
</body>
</html>

