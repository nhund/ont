tinyMCEPopup.requireLangPack();

var addhintDialog = {
	init : function() {
		var f = document.forms[0];
		ed = tinyMCEPopup.editor
		var e = ed.dom.getParent(ed.selection.getNode());

		// Get the selected contents as text and place it in the input
		//f.someval.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});		
		if(tinyMCEPopup.getWindowArg("marked_string").length > 0)
		{
			document.getElementById('gapword').innerHTML = tinyMCEPopup.getWindowArg("marked_string");
		}
		else
		{
			document.getElementById('displayGapword').style.display = 'none';
			document.getElementById('hintInput').rows = '4';
			document.getElementById('gapword').innerHTML = ""; //e.innerHTML;
		}
		
		f.hintInput.value = ed.dom.getAttrib(e, 'title');
		f.dropdown.value = ed.dom.getAttrib(e, 'href');
	},

	insert : function() {
		// Insert the contents from the input into the document
		//tinyMCEPopup.editor.execCommand('mceInsertContent', false, document.forms[0].someval.value);
		hintInput = document.getElementById('hintInput');
		dropdown = document.getElementById('dropdown');
		myDropdowns = dropdown.value.split("0i0");
		var myHref = "#";
		if(myDropdowns.length > 1)
		{
			alert("clozedrophint");
			myclass = 'clozedrophint';
			myHref = dropdown.value;
		}
		else if(hintInput.value == "")
		{
			myclass = 'cloze';
		}
		else
		{
			myclass = 'clozetip';
		}
		/*
		var url = "http://www.google.ch";
		var text = tinyMCEPopup.getWindowArg("marked_string");
		var urlMarkup = '<a href="' + url + '" target="_blank">' + (text || url.replace(/http(s)?:\/\//i, '')) + '</a>';
        tinyMCEPopup.editor.execCommand('mceInsertContent', false, urlMarkup);
		*/
		
		if(tinyMCEPopup.getWindowArg("marked_string").length > 0)
		{
			tinyMCEPopup.editor.execCommand("mceInsertLink", false, { href: myHref, title:hintInput.value, 'class':myclass}, {skip_undo : 1});
		}
		else
		{
			tinyMCEPopup.editor.execCommand('mceInsertContent', false, ed.dom.createHTML('img', {
				src : '/images/buttons/info.gif',
				title : hintInput.value,
				align: 'baseline',
				border : 0
			}));			
		}
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add(addhintDialog.init, addhintDialog);
