#!/bin/bash
#for i in `seq 1 100000`;do php post_data.php $(($i % 2)) $i;done
#for i in `seq 1 100000`;do php post_data.php  $i;sleep .7;done
#for i in `seq 1 100000`;do php post_data.php $i ;done
for i in `seq 1 100000`;do php post_data.php ;done
