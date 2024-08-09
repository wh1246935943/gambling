function winScale(){
    var win = $(window).width();
    if( win > 640 ){
        return false;      
    }else{
        var ifm = $('.game_era iframe');
        var num = win/1000;
        ifm.css({'transform':'scale('+num+')','-webkit-transform':'scale('+num+')'});
    } 
}
winScale();