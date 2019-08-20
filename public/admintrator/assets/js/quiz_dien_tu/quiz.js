$(document).ready(function () {
	window.onscroll = hideCharButtons;

	function hideCharButtons()
	{
		$("#charButtons").hide();
	}

	function getPosition (element) {
		var p = {x: element.offsetLeft || 0, y:element.offsetTop || 0};
		while (element = element.offsetParent) {
			p.x += element.offsetLeft;
			p.y += element.offsetTop;
		}
		return p;
	};

	function getStyle(el,styleProp) {
		var camelize = function (str) {
			return str.replace(/\-(\w)/g, function(str, letter){
				return letter.toUpperCase();
			});
		};

		if (el.currentStyle) {
			return el.currentStyle[camelize(styleProp)];
		} else if (document.defaultView && document.defaultView.getComputedStyle) {
			return document.defaultView.getComputedStyle(el,null)
			.getPropertyValue(styleProp);
		} else {
			return el.style[camelize(styleProp)];
		}
	}

	function remember(Feld)
	{
   //TextFeld = Feld;

   var charButtons = document.getElementById("charButtons");
   if(charButtons)
   {
   	if(charButtons.innerHTML.length > 0)
   	{
   		var inputPos = getPosition(Feld);

   		$("#charButtons").show();

   		charButtonsHeight = charButtons.offsetHeight;

   		var topPos = inputPos.y - 35 - charButtonsHeight;
   		var contentDiv = document.getElementById("contentDiv");
   		if(contentDiv.scrollTop > 0)
   		{
   			topPos = inputPos.y - contentDiv.scrollTop;
   		}

   		$("#charButtons").css({ top: topPos + 'px', left: (inputPos.x - 30) + 'px' });

   		TextFeld = Feld;
   	}
   }
}
function addchar(Knopf)
{
	setfoc();

	if (null!=TextFeld && null!=TextFeld.selectionStart)
	{
		pos = TextFeld.selectionStart;

		TextFeld.value = TextFeld.value.substring(0, pos)+Knopf.value+TextFeld.value.substring(TextFeld.selectionEnd);
		TextFeld.setSelectionRange(pos+Knopf.value.length,pos+Knopf.value.length);
	}
	return true;

}
function setfoc()
{
	TextFeld.focus();
}
});