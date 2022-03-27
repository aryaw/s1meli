$(document).ready(function(){
	var sidebarCollapse = localStorage['collapse-indicator'] || 'false';    
	if(sidebarCollapse === 'true'){
		$('body').addClass('sidebar-collapse');
	}
  
  	$(".auto-close-alert").fadeTo(2000, 500).slideUp(500, function(){
    	$(".auto-close-alert").slideUp(500);
	});

	$('body').on('click', '.deleteDialog', function(event){
        event.preventDefault();
        var title = $(this).data('title');
        var redirect = $(this).attr('href');
        var message = 'Delete ' + '"' + title + '" ?';
        if($(this).data('message')){
            message = $(this).data('message');
        }

        var modalRemove = $('#modalRemove');
        modalRemove.modal();
        modalRemove.find('.modal-body h5').text(message);
        modalRemove.find('#confirm-delete').click(function(e){
            e.preventDefault();
            window.location.href = redirect;
        });
    });

    $('.input-price').each(function(index, elem) {
        var value = $(this).val();        
        $(this).val(thousandFunction(value));
    });    

});

$('.datepicker').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
    zIndexOffset: 2000
});

$('.select2-multipe').select2();
$('.select2').select2();
$('.select2-tag').select2({
    tags: true
});

 window.thousandFunction = function(num) {
    var number = num.toString().replace(/[^,\d]/g, '').toString(),
        split = number.split(','),
        remaining = split[0].length % 3,
        value = split[0].substr(0, remaining),
        thousand = split[0].substr(remaining).match(/\d{3}/gi);

    if (thousand) {
        separator = remaining ? '.' : '';
        value += separator + thousand.join('.');
    }

    return split[1] !== undefined ? value + ',' + split[1] : value;
};

window.summernoteOptions = {
    height: 300,
    toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['fontname', ['fontname']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link']],
        ['view', ['fullscreen', 'codeview', 'help']],
    ],
};

window.parsleyOptions = {
    //successClass: "has-success",
    errorClass: "has-error",
    classHandler: function (el) {
      return el.$element.closest(".form-group");
    },
    errorsWrapper: "<span class='help-block'></span>",
    errorTemplate: "<span></span>"
};

window.previewImage = function(element, imageId){
    var reader = new FileReader();
    reader.onload = function (e) {
        $(imageId).attr('src', e.target.result).show();
    };
    reader.readAsDataURL(element.files[0]);
    $(imageId).parent().show();
};

window.slugify = function(element, target){        
    var text = $(element).val()
        .toLowerCase()
        .replace(/(\w)\'/g, '$1')
        .replace(/[^a-zA-Z0-9_\-]+/g, '-')
        .replace(/\-\-+/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, '');
    $(target).val(text);
};

window.slugFormat = function(evt) {
    evt = evt || window.event;
    var charCode = evt.which || evt.keyCode;
    var charStr = String.fromCharCode(charCode);
    if ( !(/[a-z0-9-_]/i.test(charStr)) ) {
        evt.preventDefault();
    }
};

window.numericOnly = function(e) {
    var code = ('charCode' in e) ? e.charCode : e.keyCode;
    if (code != 13 && // enter        
        !(code > 47 && code < 58)) { // numeric (0-9)
        e.preventDefault();
    }
};

window.decimalOnly = function(e) {
    var code = ('charCode' in e) ? e.charCode : e.keyCode;
    if (code != 13 && // enter
        code != 46 &&
        !(code > 47 && code < 58)) { // numeric (0-9)
        e.preventDefault();
    }
};

window.thousandFormat = function(e) {        
    var format =  $(e).val().toString().replace(/\./g,'').replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    $(e).val(format);
};
