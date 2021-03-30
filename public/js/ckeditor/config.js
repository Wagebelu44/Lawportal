/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

/*CKEDITOR.editorConfig = function( config ) {
//     Define changes to default configuration here. For example:
//     config.language = 'fr';
//     config.uiColor = '#AADC6E';
    config.allowedContent = true;
//    config.allowedContent = 'td[style];span[style]';
//    config.extraAllowedContent = 'td{style*};span{style*}';
    config.toolbarGroups = [
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
        { name: 'clipboard', groups: [ 'undo' ] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
        { name: 'forms', groups: [ 'forms' ] },
        '/',
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert' ] },
        '/',
        { name: 'styles', groups: [ 'styles' ] },
        { name: 'colors', groups: [ 'colors' ] },
        { name: 'tools', groups: [ 'tools' ] },
        { name: 'others', groups: [ 'others' ] },
        { name: 'about', groups: [ 'about' ] }
    ];

    config.removeButtons              = 'Save,ImageButton,Table,TextColor,NewPage,Preview,Print,Templates,Subscript,Superscript,CopyFormatting,RemoveFormat,Flash,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,FontSize,Font,Format,Styles,BGColor,Maximize,ShowBlocks,About,NumberedList,BulletedList,Outdent,Indent,Blockquote,CreateDiv,JustifyLeft,JustifyCenter,JustifyRight,JustifyBlock,BidiLtr,BidiRtl,Language,Link,Unlink,Anchor,Form,Checkbox,Radio,TextField,Textarea,Select,Button,HiddenField,SelectAll,Replace,Find';
    config.removePlugins              = 'scayt,elementspath,resize';
    config.extraPlugins               = 'image2,uploadimage';
    config.uploadUrl                  = 'https://billing.b3net.com/public/plugins/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json';
    config.filebrowserBrowseUrl       = 'https://billing.b3net.com/public/plugins/ckeditor/plugins/ckfinder/ckfinder.html?type=Images';
    config.filebrowserImageBrowseUrl  = 'https://billing.b3net.com/public/plugins/ckeditor/plugins/ckfinder/ckfinder.html?type=Images';
    config.filebrowserUploadUrl       = 'https://billing.b3net.com/public/plugins/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserImageUploadUrl  = 'https://billing.b3net.com/public/plugins/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
};
*/


CKEDITOR.editorConfig = function( config ) {
    config.allowedContent = true;
    config.toolbarGroups = [
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
        { name: 'forms', groups: [ 'forms' ] },
        '/',
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert' ] },
        '/',
        { name: 'styles', groups: [ 'styles' ] },
        { name: 'colors', groups: [ 'colors' ] },
        { name: 'tools', groups: [ 'tools' ] },
        { name: 'others', groups: [ 'others' ] },
        { name: 'about', groups: [ 'about' ] }
    ];

    config.removeButtons = 'Source,Save,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Italic,Strike,Subscript,Superscript,CopyFormatting,RemoveFormat,Outdent,Indent,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Unlink,Anchor,Flash,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,ShowBlocks,About';

    config.extraPlugins = 'html5video,widget,widgetselection,clipboard,lineutils';
    config.filebrowserUploadMethod = 'form';
    config.removePlugins = 'elementspath';

};