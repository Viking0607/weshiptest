;(function () {
        $(document)
               .on('keyup', '[name="weight"]', _checkButtonRegistration)
               .on('change', '[name="image"]', _checkButtonRegistration);

               function _checkButtonRegistration() {
                   if ( _onChangeFile() && _onChangeWeight() ) {
                       $('form#registration_perhibition input[type="submit"]').removeAttr('disabled');
                       $('.prohibition-error').css('display', 'none')
                   }
                   else {
                       $('form#registration_perhibition input[type="submit"]').attr('disabled', 'disabled');
                       $('.prohibition-error').css('display', 'block').find('span').text("Для регистрации необходимо ввести вес и прикрепить фотографию!");
                   }
               }

               function _onChangeWeight(event) {
                   let $evt = $('[name="weight"]');
                   let value = $evt.val();
                   if( value.length > 0 ) {
                       return true;
                   }
                   else {
                       return false;
                   }
               }

               function _onChangeFile(event) {
                   let $evt = $('[name="image"]');
                   console.log(rightFileExtension());
                   let value = $evt.val();
                   if( value != "" ) {
                       if(rightFileExtension()) {
                           return true;
                       }
                       else {
                           $('[name="image"]').val('');
                           alert("Файл имеет наверное расширение!");
                           return false;
                       }
                   }
                   else {
                       return false;
                   }
               }
               
               function rightFileExtension() {
                    let exts = ['.jpg', '.png', '.JPG', '.PNG'];
                    var fileName = $('[name="image"]').val();
                    return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
                }

})()
