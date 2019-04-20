<?php
function getimgsize($imgurl){
    $imgsize=getimagesize($imgurl);

    if ($imgsize[0]<$imgsize[1]){
        return 1;
    }else{
        return 0;
    }

}