<?php
function countInRange($numbers,$lowest,$highest){
//bounds are included, for this example
    return count(array_filter($numbers,function($number) use ($lowest,$highest){
                return ($lowest<=$number && $number <=$highest);
            })
    );
}

$numbers = ['arr','arr',1,1,1,3,10,11,12, 19, 20];

echo countInRange($numbers,1,3)."<br>"; // echoes 6
echo countInRange($numbers,4,18)."<br>"; // echoes 7
echo countInRange($numbers,19,20)."<br>"; //echoes 0