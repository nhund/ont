@push('css')
{{-- <link href="{{asset('/public/admintrator/assets/css/animate.min.css')}}" type="text/css" rel="stylesheet"> --}}
<style type="text/css">
#txtQuestion1_makeDropdownButton_en {
	display: none;
}

#txtQuestion1_moreOptions_en {
	display: none;
}
</style>
@endpush
@push('js')
<script src="{{ asset('/public/admintrator/assets/js/quiz_dien_tu/quiz.js') }}"></script>
<script src="{{ asset('/public/admintrator/assets/js/quiz_dien_tu/ASCIIMathMLwFallback.js') }}"></script>
<script src="{{ asset('/public/admintrator/assets/js/quiz_dien_tu/tiny_mce.js') }}"></script>
{{-- <script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script> --}}
{{-- <script src="https://www.learnclick.com/js/tiny_mce/tiny_mce.js?v=3.1"></script> --}}
{{-- <script src="{{ asset('/public/admintrator/assets/plugins/form-ckeditor/ckeditor.js') }}"></script> --}}
<script type="text/javascript">
		// var AMTcgiloc = "http://www.learnclick.com/images/mimetex.cgi";  		//change me
	</script>			
	<script type="text/javascript">
		var itemCount = 1;

		var defaultTinyMCE = [{
    plugins : 'paste,addhint,makedropdown,inlinepopups,media,advimage,simplelink,fullscreen,directionality,openmanager', // - tells TinyMCE to skip the loading of the plugin
    language : "en",
    mode : "textareas",
    editor_selector : "question",
    browser_spellcheck: true,
    theme : "advanced",
    file_browser_callback : "openmanager",
    open_manager_upload_path: '../../../../useruploads/1/',
    relative_urls : false,
    theme_advanced_font_sizes : "10px,12px,14px,18px,24px,36px,96px",
    theme_advanced_buttons1 : "createGapButton_en, deleteGapButton_en, addHintButton_en, makeDropdownButton_en, moreOptions_en",
    theme_advanced_buttons2 : "bold,italic,underline,forecolor,fontsizeselect,bullist,numlist,justifyleft,justifycenter,justifyright,justifyfull,rtl,asciimathcharmap,image,media,simplelink,pastetext,fullscreen",
    theme_advanced_buttons3 : "",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "none",
    media_strict: false,
    entity_encoding : "raw",
    setup : function(ed) {
    	ed.addShortcut('ctrl+g', 'myShortcut', 'createGap');
        // Add a custom button
        ed.addButton('createGapButton_en', {
        	title : 'Create/Edit Gap',
        	image : '{{ web_asset('public/images/creategap_en.gif') }}',
        	cmd : 'createGap',
        });

        ed.addCommand('createGap', function() {
        	ed.focus();
        	if(ed.selection.getContent({format : 'text'}).length > 0)
        	{
        		ed.execCommand("mceInsertLink", false, { href: "#mce_temp_url#", title:'', 'class':'cloze' }, {skip_undo : 1});
        		tinyMCE.activeEditor.selection.collapse();

                //added this as a way to refresh the content, as otherwise the whitespace doesn't display in Chrome between selected gaps
                ed.setContent(ed.getContent({format : 'html'}))

            }
            else
            {
            	var $dialog = $('<div style="text-align:left">Please select some text before you click on "Create Gap".</div>')
            	.dialog({
            		autoOpen: true,
            		title: 'Create Gap',
            		width: 300,
            		height: 100
            	});
            }
        });

        ed.addButton('deleteGapButton_en', {
        	title : 'Remove Gap',
        	image : '{{ web_asset('public/images/removegap_en.gif') }}',
        	onclick : function() {
                // Add you own code to execute something on click
                ed.focus();
                //ed.execCommand('unlink');
                if(!ed.dom.getParent(ed.selection.getNode(), 'A'))
                {
                	var $dialog = $('<div style="text-align:left">Please click on a gap word before you click on "Remove Gap".</div>')
                	.dialog({
                		autoOpen: true,
                		title: 'Remove Gap',
                		width: 300,
                		height: 100
                	});
                }
                else
                {
                	var inst = tinyMCE.activeEditor;
                	var elm = inst.selection.getNode();
                	ed.selection.select(inst.dom.getParent(elm, "A"));
                	inst.selection.setContent(ed.selection.getContent({format : 'text'}))
                	//ed.selection.setContent(ed.selection.getContent({format : 'text'}));
                }
            }
        });
        ed.addButton('addHintButton_en', {
        	title : 'Add a hint',
        	image : '{{ web_asset('public/images/addhint_en.gif') }}',
        	onclick : function() {
                    // Add you own code to execute something on click
                    ed.focus();
                    //var e = ed.dom.getParent(ed.selection.getNode());
                    if(ed.dom.getAttrib(e, 'href').length == 0 && ed.selection.getContent({format : 'text'}).length == 0)
                    {
                    	var e = "";
    					/*
                 	var $dialog = $('<div style="text-align:left">Please click on a gap word before you click on "Add a Hint".</div>')
            			.dialog({
            				autoOpen: true,
            				title: 'Add a Hint',
            				width: 300,
            		        height: 100
            			});
            			*/
            		}
            		else
            		{
            			var inst = tinyMCE.activeEditor;
            			var elm = inst.selection.getNode();
            			ed.selection.select(inst.dom.getParent(elm, "A"));
                    	//var e = ed.dom.getParent(ed.selection.getNode());
                    	ed.execCommand('mceAddhint');
                    }
                }
            });
        // ed.addButton('makeDropdownButton_en', {
        // 	title : 'Make Dropdown',
        // 	image : '/images/buttons/makeDropdown_en.gif',
        // 	onclick : function() {
        //          // Add you own code to execute something on click
        //          ed.focus();
        //          var e = ed.dom.getParent(ed.selection.getNode());
        //       	                  		//if(!ed.dom.getParent(ed.selection.getNode(), 'A'))
        //       	                  		if(ed.dom.getAttrib(e, 'href').length == 0 && ed.selection.getContent({format : 'text'}).length == 0)
        //       	                  		{
        //       	                  			var $dialog = $('<div style="text-align:left">Please click on a gap word before you click on "Make Dropdown".</div>')
        //       	                  			.dialog({
        //       	                  				autoOpen: true,
        //       	                  				title: 'Make Dropdown',
        //       	                  				width: 300,
        //       	                  				height: 200
        //       	                  			});
        //       	                  		}
        //       	                  		else
        //       	                  		{
        //       	                  			var inst = tinyMCE.activeEditor;
        //       	                  			var elm = inst.selection.getNode();
        //       	                  			ed.selection.select(inst.dom.getParent(elm, "A"));
        //
        //       	                  			ed.execCommand('mceMakeDropdown');
        //       	                  		}
        //       	                  	}
        //       	                  });
        // ed.addButton('moreOptions_en', {
        // 	title : 'More Options',
        // 	image : '/images/buttons/moreOptions_en.gif',
        // 	onclick : function() {
        // 		var $dialog = $('<div></div>')
        // 		.load('/cloze/moreoptions')
        // 		.dialog({
        // 			autoOpen: true,
        // 			title: 'More Options',
        // 			width: 350,
        // 			height: 280
        // 		});
        // 	}
        // });

    }
}];

var configArray = [{
    plugins : 'paste,inlinepopups,media,advimage,simplelink,fullscreen,directionality,asciimath,openmanager', // - tells TinyMCE to skip the loading of the plugin
    language : "en",
    mode : "textareas",
    forced_root_block : "",
    force_br_newlines : true,
    force_p_newlines : false,
    editor_selector : "optionBox",
    browser_spellcheck: true,
    theme : "advanced",
    file_browser_callback : "openmanager",
    open_manager_upload_path: '../../../../useruploads/1/',
    theme_advanced_buttons1 : "bold,italic,underline,forecolor,fontsizeselect,bullist,numlist,justifyleft,justifycenter,justifyright,justifyfull,rtl,asciimathcharmap,image,media,simplelink,pastetext,fullscreen",
    theme_advanced_buttons2 : "",
    theme_advanced_buttons3 : "",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "none",
    media_strict: false,
    entity_encoding : "raw"
}]

function generateTinyMCE(currentItem)
{ 
	tinyMCE.settings = defaultTinyMCE[0];
	tinyMCE.triggerSave();
	for(var x = 0; x <= itemCount; x++)
	{
		var myTextarea = document.getElementById("txtQuestion" + x);
		tinyMCE.execCommand('mceRemoveControl', false, myTextarea);
	} 
	myTextarea = document.getElementById("txtQuestion" + currentItem);
	//console.log("xxx",myTextarea);
	tinyMCE.execCommand('mceAddControl', false, myTextarea.id);
	
}

function generateTinyMCEforAnswer(currentItem)
{
	tinyMCE.settings = configArray[0];
	var answerArea = document.getElementById("item" + currentItem);
	tinyMCE.execCommand('mceAddControl', true, answerArea.id);

	var answerIfr = document.getElementById("item" + currentItem + "_ifr");
	var answerTbl = document.getElementById("item" + currentItem + "_tbl");

	if(answerIfr != null)
	{
		answerIfr.style.height = '40px';
	}
	if(answerTbl != null)
	{
		answerTbl.style.height = '40px';
	}
}

function generateTinyMCEforDirections(qNr)
{
	tinyMCE.settings = configArray[0];
	var directionsArea = document.getElementById("directions" + qNr);

	tinyMCE.execCommand('mceAddControl', true, directionsArea.id);

	var formatDirections = document.getElementById("formatDirections" + qNr);
	formatDirections.style.display = 'none';

	var directionsIfr = document.getElementById("directions" + qNr + "_ifr");
	var directionsTbl = document.getElementById("directions" + qNr + "_tbl");

	if(directionsIfr != null)
	{
		directionsIfr.style.height = '50px';
	}

	if(directionsTbl != null)
	{
		directionsTbl.style.height = '50px';
		directionsTbl.style.marginBottom = "5px";
	}
}

function generateTinyMCEforExplanation(qNr)
{
	tinyMCE.settings = configArray[0];
	var explanationArea = document.getElementById("explanationID" + qNr);
	tinyMCE.execCommand('mceAddControl', true, explanationArea.id);

	var formatExplanation = document.getElementById("formatExplanation" + qNr);
	formatExplanation.style.display = 'none';

	var explanationIfr = document.getElementById("explanationID" + qNr + "_ifr");
	var explanationTbl = document.getElementById("explanationID" + qNr + "_tbl");

	if(explanationIfr != null)
	{
		explanationIfr.style.height = '50px';
	}
	if(explanationTbl != null)
	{
		explanationTbl.style.height = '50px';
	}
}


window.onload = function()
{
	for(var qNr = 0; qNr <= 3; qNr++)
	{
		//var directions = document.getElementById('directions' + qNr).value;

		if($("#directions" + qNr).html() != $("#directions" + qNr).text())
		{
			$("#formatDirections" + qNr).trigger("click");
		}

		//var explanation = document.getElementById('explanationID' + qNr).value;

		//text() will return text inside html tag, only then trigger generateTinyMCEforExplanation
		if($("#explanationID" + qNr).html() != $("#explanationID" + qNr).text())
		{
			$("#formatExplanation" + qNr).trigger("click");
		}
	}

	var answers = document.getElementsByClassName('optionBox');
	for(o = 0; o < answers.length; o++)
	{
		var answer = $("#" + answers[o].id);

		if(answer.html() != answer.text())
		{
			var formatAnswer = "formatAnswer" + answers[o].id.replace("item", "");
			//calls generateTinyMCEforAnswer
			$("#" + formatAnswer).hide();
			$("#" + formatAnswer).trigger("click");
		}

	}

}
</script>
<script>
	function addDragDropChoice(nr)
	{
		var choices = document.getElementById("choices" + nr);
		var dragboxes = document.getElementById("dragbox" + nr);

		var spanTag = document.createElement("span");
		spanTag.style.display = "block";
		spanTag.style.clear = "both";
		spanTag.setAttribute("class", "boxchoices" + nr);
		spanTag.id = "dragbox" + nr + "_" + $('.boxchoices' + nr).length;

		choices.appendChild(spanTag);

		var divLeft = document.createElement("div");
		divLeft.style.cssFloat = "left";

		var textbox = document.createElement('input');
		textbox.name = 'dragbox[' + nr + '][]';
		textbox.id = "dragbox" + nr + $('.boxchoices' + nr).length;
		textbox.size = "50";
		textbox.setAttribute("class", "optionBox");
		divLeft.appendChild(textbox);

		var divRight = document.createElement("div");
		divRight.style.cssFloat = "left";
		divRight.style.height = "15px";
		divRight.style.marginTop = "3px";

		var deleteItemLink = document.createElement('a');
		deleteItemLink.setAttribute('href', 'javascript:;');
		deleteItemLink.setAttribute("onClick", "deleteDragbox(" + nr + ", " + ($('.boxchoices' + nr).length - 1) + ")");
		deleteItemLink.innerHTML = "<img src=\"/images/symbole/falsch.gif\" border=0 style=\"padding-left: 3px\">";
		divRight.appendChild(deleteItemLink);

		spanTag.appendChild(divLeft);
		spanTag.appendChild(divRight);
	}
	function deleteDragbox(nr, itemnr)
	{
		var item = document.getElementById("dragbox" + nr + "_" + itemnr);
		item.style.display = 'none';

		var deletedItem = document.createElement('input');
		deletedItem.type = 'hidden';
		deletedItem.name = 'deletedItem' + nr + "_" + itemnr;
		deletedItem.value = 'true';
		item.appendChild(deletedItem);
	}

	function addItem(nr)
	{
		var options = document.getElementById("options" + nr);
		var items = document.getElementById("item" + nr);

		var spanTag = document.createElement("span");
		spanTag.style.display = "block";
		spanTag.style.clear = "both";
		spanTag.id = "item" + nr + "_" + $('.correctAnswer' + nr).length;

		options.appendChild(spanTag);

		var divLeft = document.createElement("div");
		divLeft.style.cssFloat = "left";

		var textbox = document.createElement('textarea');
		textbox.name = 'item[' + nr + '][]';
		textbox.id = "item" + nr + $('.correctAnswer' + nr).length;
		textbox.setAttribute("class", "optionBox");
		textbox.cols = 50;
		textbox.rows = 1;
		textbox.style.resize = "none";
		textbox.style.height = "15px";
		divLeft.appendChild(textbox);

		var divRight = document.createElement("div");
		divRight.style.cssFloat = "left";
		divRight.style.height = "15px";
		divRight.style.marginTop = "3px";

		var formatImg = document.createElement('img');
		formatImg.setAttribute("src", "/images/buttons/editor.png");
		formatImg.style.paddingLeft = "3px";
		formatImg.style.paddingRight = "10px";
		formatImg.setAttribute("onClick", "generateTinyMCEforAnswer('" + nr + ($('.correctAnswer' + nr).length) + "')");
		divRight.appendChild(formatImg);

		var correctBox = document.createElement('input');
		correctBox.type = getType(nr);
		correctBox.name = 'correct[' + nr + '][]';
		correctBox.value = $('.correctAnswer' + nr).length;
		correctBox.setAttribute("class", "correctAnswer" + nr);
		divRight.appendChild(correctBox);

		var label = document.createElement('label');
		label.appendChild(document.createTextNode('Correct Answer'));
		divRight.appendChild(label);

		var deleteItemLink = document.createElement('a');
		deleteItemLink.setAttribute('href', 'javascript:;');
		deleteItemLink.setAttribute("onClick", "deleteItem(" + nr + ", " + ($('.correctAnswer' + nr).length - 1) + ")");
		deleteItemLink.innerHTML = "<img src=\"/images/symbole/falsch.gif\" border=0 style=\"padding-left: 3px\">";
		divRight.appendChild(deleteItemLink);

		spanTag.appendChild(divLeft);
		spanTag.appendChild(divRight);
	}
	function addInstructions()
	{
		var addInstructionsLinks = document.getElementById("addInstructions");
		addInstructionsLinks.style.display = 'none';

		var addInstructionsLinks = document.getElementById("divInstructions");
		addInstructionsLinks.style.display = 'block';

		tinyMCE.settings = configArray[0];
		tinyMCE.execCommand('mceAddControl', false, "instructions");
	}

	function addCompletedMessage()
	{
		var addCompletedMessageLinks = document.getElementById("addCompletedMessage");
		addCompletedMessageLinks.style.display = 'none';

		var addCompletedMessageLinks = document.getElementById("divCompletedMessage");
		addCompletedMessageLinks.style.display = 'block';

		tinyMCE.settings = configArray[0];
		tinyMCE.execCommand('mceAddControl', false, "completedMessage");
	}

	function addQuestion(totalQuestions)
	{
		var questionNr = $('.question').length;

		arrQuestions = document.getElementsByClassName("qNr");
		if(arrQuestions.length > 0)
		{
			questionNr = parseInt(arrQuestions[(arrQuestions.length - 1)].value) + 1;
		}

		quizform.btnAddQuestion.disabled = true;

		if(questionNr == 0)
		{
			var introduction = document.getElementById("introduction");
			introduction.style.display = 'none';
		}

		var saveButtons = document.getElementById("saveButtons");
		saveButtons.style.display = 'block';

		itemCount = questionNr;
		if(itemCount > 0)
		{
			var reorderQuestions = document.getElementById("reorderQuestions");
			reorderQuestions.style.display = 'block';
		}

		questiontype = getType("New");

		itemCount = questionNr;
		$.ajax({
			type: "POST",
			url: "/quiz/addQuestion",
			crossDomain: true,
			data: "questionNr=" + questionNr + "&questiontype=" + questiontype,
			success: function(msg){
				$("#questions").append(msg);
				generateTinyMCE(questionNr);
			}
		});

		setTimeout('$("#addQuestionButton").removeAttr("disabled")', 1500);
	}

	function changeType(nr, sel)
	{
		type = sel.value;
		oldType = sel.oldvalue;

		var items = "";
		var displayOptions = document.getElementById("displayOptions" + nr);
		var toolbar1 = document.getElementById("txtQuestion" + nr + "_toolbar1");
		var questionIfr = document.getElementById("txtQuestion" + nr + "_ifr");
		var questionTbl = document.getElementById("txtQuestion" + nr + "_tbl");
		var makeDropdown = document.getElementById("txtQuestion" + nr + "_makeDropdownButton_en");
		var moreOptions = document.getElementById("txtQuestion" + nr + "_moreOptions_en");

		var displayMaxPoints = document.getElementById("maxPoints" + nr);

		if(type == "essay" || type == "checkbox" || type == "radio")
		{
			displayMaxPoints.style.display = 'block';
		}
		else
		{
			displayMaxPoints.style.display = 'none';
		}

		if(type == "checkbox" || type == "radio")
		{
			toolbar1.style.display = 'none';
			questionIfr.style.height = '100px';
			questionTbl.style.height = '100px';

			if(type != "essay" && type != "description")
			{
				displayOptions.style.display = 'block';

				var options = document.getElementById("options" + nr);

				if(options)
				{
					inputs = options.getElementsByTagName("input");
					for (j = 0; j < inputs.length; j++) {
						if(inputs[j].type=="text")
						{
							items += inputs[j].value + "|";
						}
					}
				}
			}
		}
		else
		{
			displayOptions.style.display = 'none';
			toolbar1.style.display = 'block';

			if(type == "essay" || type == "description")
			{
				toolbar1.style.display = 'none';
				questionIfr.style.height = '100px';
				questionTbl.style.height = '100px';
			}
			else
			{
				displayOptions.style.display = 'none';
				questionIfr.style.height = '200px';
			}
		}

		if(type == "blank" || type == "onlyblank")
		{
			makeDropdown.style.display = 'block';
		}
		else
		{
			makeDropdown.style.display = 'none';
		}

		if(type == "blank" || type == "onlyblank")
		{
			moreOptions.style.display = 'block';
		}
		else
		{
			moreOptions.style.display = 'none';
		}

		$.ajax({
			type: "POST",
			url: "/quiz/getTypeOptions",
			data: "nr=" + nr + "&type=" + type + "&items=" + items,
			success: function(msg){
				$("#options" + nr).html(msg);
			}
		});
	}

	function checkShowAnswers()
	{
		var maxAttempts = document.getElementById("maxAttempts");
		if(maxAttempts.value > 0)
		{
			$("#showAnswersButton").hide("fast");
			$("#showAnswersAfterNoAttemptsLeft").show("fast");
		}
		else
		{
			$("#showAnswersButton").show("fast");
			$("#showAnswersAfterNoAttemptsLeft").hide("fast");
		}
	}

	function deleteItem(nr, itemnr)
	{
		var item = document.getElementById("item" + nr + "_" + itemnr);
		item.style.display = 'none';

		var deletedItem = document.createElement('input');
		deletedItem.type = 'hidden';
		deletedItem.name = 'deletedItem' + nr + "_" + itemnr;
		deletedItem.value = 'true';
		item.appendChild(deletedItem);
	}

	function addDirections(nr)
	{
		var labelDirections = document.getElementById("labelDirections" + nr);
		labelDirections.innerHTML = 'Directions:';

		var directions = document.getElementById("directions" + nr);
		directions.style.display = 'inline';

		var formatDirections = document.getElementById("formatDirections" + nr);
		formatDirections.style.display = 'inline';

	}
	function deleteQuestion(nr)
	{
		var del = confirm('Are you sure you want to delete this question?');

		if(del)
		{
			var question = document.getElementById("question" + nr);
			question.style.display = 'none';

			var deletedQuestion = document.createElement('input');
			deletedQuestion.type = 'hidden';
			deletedQuestion.name = 'deletedQuestion' + nr;
			deletedQuestion.value = 'true';
			question.appendChild(deletedQuestion);
		}
	}

	function getType(nr)
	{
		var e = document.getElementById("questionType" + nr);
		var type = e.options[e.selectedIndex].value;

		return type;
	}
</script>
<script>
	$('.form_dien_tu_doan_van .question_dt').each(function(i, obj) {
		//console.log($(obj));
		generateTinyMCE($(obj).attr('data-id'));
    
	});
	
</script>
<script>
	$(".contentfullscroll").height(($(window).height() - 150));
</script>
<script type="text/javascript">
	$('.nav-tabs a').click(function () {
		if ($(this).hasClass('tabDescription')) {
			$('.editBtn').show();
		} else {
			$('.editBtn').hide();
		}
	});

</script>
@endpush
<div class="contentfull" onscroll="hideCharButtons();" id=contentDiv>			
	<div id="questions">   
		@if(isset($edit) && $edit)
		<div class="form-group row">
			<div class="col-sm-12">Giải thích chung</div>
			<div class="col-sm-12">
			<div class="box_content_t">
				<textarea name="interpret_dv_global" class="col-sm-12">{{ $question->interpret_all }}</textarea>	
				<div class="box_media">                            
						@include('backend.lesson.question.options.action',['show_format_content'=>true])
					</div>
			</div>
			</div>
		</div>
			@foreach($question->childs as $question_child)			
				@include('backend.lesson.question.dien_tu_doan_van.dien_tu_doan_van_box',['count'=>1,'question_child'=>$question_child])
			@endforeach	
			<input type="hidden" class=qNr name="qNr[1]" value="1">
			<div class="form-group row box_add_btn">
				<div class="col-sm-12">
					<button type="button" class="btn btn-primary add_question" data-count="1000000">Thêm câu hỏi</button>
				</div> 
			</div>
		@else
		<div class="form-group row">
			<div class="col-sm-12">Giải thích chung</div>
			<div class="col-sm-12">
			<div class="box_content_t">
				<textarea name="interpret_dv_global" class="col-sm-12"></textarea>	
				<div class="box_media">                            
						@include('backend.lesson.question.options.action',['show_format_content'=>true])
					</div>
			</div>
			</div>
		</div> 
		@include('backend.lesson.question.dien_tu_doan_van.dien_tu_doan_van_box',['count'=>1])
		<input type="hidden" class=qNr name="qNr[1]" value="1">
		<div class="form-group row box_add_btn">
			<div class="col-sm-12">
				<button type="button" class="btn btn-primary add_question" data-count="1">Thêm câu hỏi</button>
			</div> 
		</div>
		@endif 
		
	</div>			

</div>