$(document).ready(function() {
  var stt_start = 1;
  function toObject(arr) {
    var rv = {};
    for (var i = 0; i < arr.length; ++i)
      if (arr[i] !== undefined) rv[i] = arr[i];
    return rv;
  }
  document.addEventListener(
    "message",
    function(event) {
      alert(event.data);
      let params = JSON.parse(event.data);
      if (params.action == "check_submit") {
        checkSubmit();
      }
      if(params.action == "next_question")
      {
        $('.question_type').hide();
        $('.question_type.question_stt_'+parseInt(params.stt)).show();
        let params = {
          action: "next_question_success",
        };
        window.ReactNativeWebView.postMessage(JSON.stringify(params));
      }
      //alert(event.data);
    },
    false
  );
  //ham kiem tra submit cau hoi
  function checkSubmit()
  {
    var form_active  = $("#app").find(".question_type[data-stt='" + stt_start + "']");

    var question_type =  form_active.find('input[name="question_type"]').val();
    alert(question_type);
    if(parseInt(question_type) == 4)
    {
      //cau hoi trac nghiem
      processCauHoiTracNghiem(form_active);
    }
    if(parseInt(question_type) == 3)
    {
      //cau hoi dien tu
    }
    if(parseInt(question_type) == 5)
    {
      //cau hoi dien tu doan van
    }
    //console.log(form_active);
  }
  function processCauHoiTracNghiem(form_active)
  {
    var form_data = form_active.serializeArray();
    alert("form_data",JSON.stringify(form_data));
    let $all_answer = [];
    form_active.find(".form_trac_nghiem").find("input[type=radio]").each(function() {
      if (jQuery.inArray($(this).attr("name"), $all_answer) == -1) {
        $all_answer.push($(this).attr("name"));
      }
    });
    let data = {};
    let check_answer = 0;
    for (let i = 0; i < form_data.length; i++) {
      var element = {};
      let name = form_data[i].name;

      if (jQuery.inArray(name, $all_answer) != -1) {
        check_answer += 1;
      }
      data[name] = form_data[i].value;
      //element[name] = form_data[i].value;
      //data.push(element);
    }

    let params = {};
    if(check_answer == $all_answer.length)
    {
      params = {
        action: "submitQuestion",
        typeQuestion: "multiple_Choice",
        replyALl: true,
        data: data
      };
    }else{
      params = {
        action: "submitQuestion",
        typeQuestion: 4,
        replyALl: false,
        data: []
      };
    }

    window.ReactNativeWebView.postMessage(JSON.stringify(params));
  }
  //cau hoi trac nghiem
  $(".question-app-trac-nghiem .list-answer .answer").on("click", function(e) {
    var $this = $(this);
    $this
      .closest(".list-answer")
      .find(".answer")
      .removeClass("checked");
    $this.find(".answer_radio").prop("checked", true);
    $this.addClass("checked");

    //checkSubmit();
    // var form_data = $this.closest(".form_trac_nghiem").serializeArray();
    //
    // let $all_answer = [];
    // $(".form_trac_nghiem input[type=radio]").each(function() {
    //   if (jQuery.inArray($(this).attr("name"), $all_answer) == -1) {
    //     $all_answer.push($(this).attr("name"));
    //   }
    // });
    // let data = [];
    // let check_answer = 0;
    // for (let i = 0; i < form_data.length; i++) {
    //   var element = {};
    //   let name = form_data[i].name;
    //
    //   if (jQuery.inArray(name, $all_answer) != -1) {
    //     check_answer += 1;
    //   }
    //   element[name] = form_data[i].value;
    //   data.push(element);
    // }
    //
    // let params = {
    //   action: "submitQuestion",
    //   typeQuestion: "multiple_Choice",
    //   replyALl: check_answer == $all_answer.length ? true : false,
    //   data: data
    // };
    // window.ReactNativeWebView.postMessage(JSON.stringify(params));
  });
  //comment
  $(".question-app-trac-nghiem .list-action .icon-comment").on(
    "click",
    function(e) {
      var $this = $(this);
      if ($this.hasClass("active")) {
        $this.removeClass("active");
        let data = {
          action: "comment",
          show_comment: false
        };
        window.ReactNativeWebView.postMessage(JSON.stringify(data));
      } else {
        $this.addClass("active");
        let data = {
          action: "comment",
          show_comment: true
        };
        window.ReactNativeWebView.postMessage(JSON.stringify(data));
      }
    }
  );
  //bookmark
  $(".question-app-trac-nghiem .list-action .icon-bookmark").on(
    "click",
    function(e) {
      var $this = $(this);
      if ($this.hasClass("active")) {
        let data = {
          action: "bookmark",
          type: 2,
          question_id: $this
            .closest(".form_trac_nghiem")
            .find('input[name="question_id"]')
            .val()
        };

        window.ReactNativeWebView.postMessage(JSON.stringify(data));
        $this.removeClass("active");
      } else {
        let data = {
          action: "bookmark",
          type: 1,
          question_id: $this
            .closest(".form_trac_nghiem")
            .find('input[name="question_id"]')
            .val()
        };
        window.ReactNativeWebView.postMessage(JSON.stringify(data));
        $this.addClass("active");
      }
    }
  );
  //hien thi goi y
  $(".question-app-trac-nghiem .list-action .icon-sugess").on("click", function(
    e
  ) {
    var $this = $(this);
    if ($this.hasClass("active")) {
      $this.removeClass("active");
      $this
        .closest(".question-app-trac-nghiem")
        .find(".content .sugess_all")
        .hide();
    } else {
      $this.addClass("active");
      $this
        .closest(".question-app-trac-nghiem")
        .find(".content .sugess_all")
        .show();
    }
  });
  // cau hoi dien tu
  //hien goi y chung
  $(".form_dien_tu .list-action .icon-sugess").on("click", function() {
    var $this = $(this);
    if ($this.hasClass("active")) {
      $this.removeClass("active");
      $this
        .closest(".form_dien_tu")
        .find(".sugess_all")
        .hide();
    } else {
      $this.addClass("active");
      $this
        .closest(".form_dien_tu")
        .find(".sugess_all")
        .show();
    }
  });

  //hien goi y cho tung cau hoi
  $(".question-app-dien-tu .question-item .head .sugess").on(
    "click",
    function() {
      var $this = $(this);
      if ($this.hasClass("active")) {
        $this.removeClass("active");
        $this
          .closest(".question-item")
          .find(".sugess_item")
          .hide();
      } else {
        $this.addClass("active");
        $this
          .closest(".question-item")
          .find(".sugess_item")
          .show();
      }
    }
  );
});
