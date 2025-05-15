$(document).ready(function(){

    var arrru = new Array ('Я','я','Ю','ю','Ч','ч','Ш','ш','Щ','щ','Ж','ж','А','а','Б','б','В','в','Г','г','Д','д','Е','е','Ё','ё','З','з','И','и','Й','й','К','к','Л','л','М','м','Н','н', 'О','о','П','п','Р','р','С','с','Т','т','У','у','Ф','ф','Х','х','Ц','ц','Ы','ы','Ь','ь','Ъ','ъ','Э','э',' ','A','S','D','F','G','H','J','K','L','Q','W','E','R','T','Y','U','I','O','P','Z','X','C','V','B','N','M');

    var arren = new Array ('ya','ya','yu','yu','ch','ch','sh','sh','sh','sh','zh','zh','a','a','b','b','v','v','g','g','d','d','e','e','e','e','z','z','i','i','j','j','k','k','l','l','m','m','n','n', 'o','o','p','p','r','r','s','s','t','t','u','u','f','f','h','h','c','c','y','y','','','','','e','e','-','a','s','d','f','g','h','j','k','l','q','w','e','r','t','y','u','i','o','p','z','x','c','v','b','n','m');

    function cyrill_to_latin(text){
        for(var i=0; i<arrru.length; i++){
            var reg = new RegExp(arrru[i], "g");
            text = text.replace(reg, arren[i]);
        }
        //return text;
        $('.translit-eng').val(text);
    }

    $('.translit').click(function(){
        var val_ru = $(this).closest('.form_translit').find('input').val();
        $('.copy_text_title').val(val_ru + "");
        $('.copy_text_bread').val(val_ru);
        val_ru = val_ru.replace(/[^a-zA-ZА-Яа-я0-9 ]/g, "");
        cyrill_to_latin(val_ru);
    });

});