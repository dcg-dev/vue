CKEDITOR.editorConfig = function (config) {
    config.contentsCss = '/ckeditor/contents.css';
    config.skin = 'icy_orange';
    config.toolbarGroups = [
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi']},
        {name: 'styles'},
        {name: 'colors'},
    ];
    config.removeButtons = 'Cut,Copy,Paste,Undo,Redo,Anchor,Underline,Strike,Subscript,Superscript';
    config.removeDialogTabs = 'link:advanced';
};
