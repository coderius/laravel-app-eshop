$(function() {
    // Delete item by click in delete button
    $('.admin-delete-item').on('click', function(e){
        var m = confirm("Подтвердить удаление поля!");
        return m;
    });

    // #aliasTranslit
    var aliasTranslit = $('#aliasTranslit');
    var aliasTranslitFrom = $('#aliasTranslitFrom');

    aliasTranslitFrom.on('propertychange input', function (e) {
        var valueChanged = false;
        if (e.type=='propertychange') {
            valueChanged = e.originalEvent.propertyName=='value';
        } else {
            valueChanged = true;
        }
        if (valueChanged) {
            aliasTranslit.text(transliterate($(this).val()));
        }
    });

    // -----------------------------------------------

    $('.Admin-alert-info').on('click', function(e){
      var k = $(this).data('k');
      var $mod = $("#exampleModal");
      var $cont = $mod.find(".modal-body").html("");
      var $ul = $(".alert-helper-"+k).find("ul").clone().appendTo($cont);
      $mod.modal("show");

      console.log(k);
    })

    function deleteImgSort(index){
      alert(index);
    }

    //Upload images
    var gallery = $(".upload-images");

    function buildGallery(index, inputFile){
        var deferred = $.Deferred();
        // console.log(inputFile);
        var reader = new FileReader();
        reader.onload = function(event) {
          console.log(inputFile.name);
            // var inpStr = "order="+index+";src="+inputFile.name;
            var inpStr = inputFile.name;
            // var myArray = [];
            //     myArray['order'] = index;
            //     myArray['src'] = inputFile.name;
            // var inpupImages = $("<input name='imagesInfo[]"+ myArray +"'  type='hidden'>");
            $( "<div class='upload-image'><img src='"+event.target.result+"'><span data-ind='"+index+"' style='cursore:pointer;font-weight:bold;' class='deleteImgSort'>X</span><input data-ind-inp='"+index+"' value='"+ inpStr +"' name='imagesInfo[]'  type='hidden'></div>" )
            .appendTo( ".upload-images" );
            //Past to result array in $('#formFileMultiple').on('change'...
            deferred.resolve(event.target.result);
        };
        reader.onerror = function(event) {
            alert("I AM ERROR: " + event.target.error.code);
            deferred.reject(event.target.error);
        };
        reader.readAsDataURL(inputFile);

      
        return deferred.promise();
    }

    

    //Is upload file by button input
    $('#formFileMultiple').on('change', function(e){
      $(".upload-images").html('');
      var $input = $(this);
      var inputFiles = this.files;
      if(inputFiles == undefined || inputFiles.length == 0) return;
      var my_array = [];
      
      $.each(inputFiles, function(index, inputFile){
        my_array.push(buildGallery(index, inputFile));
        
      });

      $.when.apply($, my_array).done(function(){
        $("#sortable").sortable({
          cursor: "move"
        });

        //Delete image from gallery
        $(".deleteImgSort").on("click", function(){
          i = $(this).attr("data-ind");
          $(this).closest( ".upload-image" ).remove();
        });

      }).fail(function(){
          
      });
      // console.log($(document).find(".upload-image"));

    });

    //If current view is update
    var loadedByController = $(".loadedByController");
    console.log(loadedByController);
    $( ".upload-images" ).html("");
    if(loadedByController.length){
      loadedByController.each(function(){
        $( "<div class='upload-image'><img src='"+ $(this).attr("data-src") +"'><span style='cursore:pointer;font-weight:bold;' class='deleteImgSort'>X</span><input value='"+ $(this).attr("data-alias") +"' name='imagesInfo[]'  type='hidden'></div>" )
            .appendTo( ".upload-images" );
        
      });
      $("#sortable").sortable({
        cursor: "move"
      });
      //Delete image from gallery
      $(".deleteImgSort").on("click", function(){
        i = $(this).attr("data-ind");
        $(this).closest( ".upload-image" ).remove();
      });
    }


    
});    


// -----------------------------------------------
//
//------------------------------------------------


function transliterate(word){
    word = word.toLowerCase();
    var answer = ""
      , a = {};

   a["Ё"]="YO";a["Й"]="I";a["Ц"]="TS";a["У"]="U";a["К"]="K";a["Е"]="E";a["Н"]="N";a["Г"]="G";a["Ш"]="SH";a["Щ"]="SCH";a["З"]="Z";a["Х"]="H";a["Ъ"]="";a[" "]="-";a[","]="";a["."]="";a["?"]="";a["!"]="";
   a["ё"]="yo";a["й"]="i";a["ц"]="ts";a["у"]="u";a["к"]="k";a["е"]="e";a["н"]="n";a["г"]="g";a["ш"]="sh";a["щ"]="sch";a["з"]="z";a["х"]="h";a["ъ"]="";a[" "]="-";
   a["Ф"]="F";a["Ы"]="I";a["В"]="V";a["А"]="А";a["П"]="P";a["Р"]="R";a["О"]="O";a["Л"]="L";a["Д"]="D";a["Ж"]="ZH";a["Э"]="E";a[" "]="-";
   a["ф"]="f";a["ы"]="i";a["в"]="v";a["а"]="a";a["п"]="p";a["р"]="r";a["о"]="o";a["л"]="l";a["д"]="d";a["ж"]="zh";a["э"]="e";a[" "]="-";
   a["Я"]="Ya";a["Ч"]="CH";a["С"]="S";a["М"]="M";a["И"]="I";a["Т"]="T";a["Ь"]="";a["Б"]="B";a["Ю"]="YU";a[" "]="-";
   a["я"]="ya";a["ч"]="ch";a["с"]="s";a["м"]="m";a["и"]="i";a["т"]="t";a["ь"]="";a["б"]="b";a["ю"]="yu";a[" "]="-";

   for (i in word){
    // console.log(i);
     if (word.hasOwnProperty(i)) {
       if (a[word[i]] === undefined){
         answer += word[i];
       } else {
         answer += a[word[i]];
       }
     }
   }
   return answer;
}

function aliasAutoPast( from, to ) {

  var from = from;
  var to = to;

  from.on('propertychange input', function (e) {
        var valueChanged = false;

        if (e.type=='propertychange') {
          valueChanged = e.originalEvent.propertyName == 'value';
        } else {
          valueChanged = true;
        }
        if (valueChanged) {
          var t = transliterate($(this).val()); 
          to.val(t);
        }
  });
}

function textAutoPast( from, to ) {

  var from = from;
  var to = to;
  var setTextToAccess = false;

  from.on('propertychange input', function (e) {
        var valueChanged = false;

        if (e.type=='propertychange') {
          valueChanged = e.originalEvent.propertyName == 'value';
        } else {
          valueChanged = true;
        }

        if (valueChanged && to.val().length === 0){
          setTextToAccess = true;
        }
        if (setTextToAccess) {
          var t = $(this).val();
          to.val(t);
        }
  });
}

