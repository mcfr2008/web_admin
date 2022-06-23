<script>
    

    function date_thai(dateObject)
    {
        var thaimonth =["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"]; 
        var thaiweek = ["วันอาทิตย์","วันจันทร์","วันอังคาร","วันพุธ","วันพฤหัส","วันศุกร์","วันเสาร์"];

        var d = new Date(dateObject.replace(/\s/, 'T'));
        var day = [d.getDate()];
        var month = thaimonth[d.getMonth()] ;
        var year = d.getFullYear()+543;
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        var date = 'วัน' + 'ที่ ' + day + " เดือน " + month + " ปี " + year;

        return date;
    };

    function date(dateObject)
    {
        var d = new Date(dateObject.replace(/\s/, 'T'));
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear()+543;
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        var date = day + "/" + month + "/" + year;

        return date;
    };

    function time(dateObject)
    {
        var t = new Date(dateObject.replace(/\s/, 'T'));
        var Hour = t.getHours();
        var Minutes = t.getMinutes() ;
        var Seconds = t.getSeconds();

        var time = Hour + ":" + Minutes + ":" + Seconds;

        return time;
    };

	function checknull(data) 
    {

        if(data == '' || data == null){
            result = '';
        }else{
            result = data;
        }
        
        return result;
    };	


</script>
