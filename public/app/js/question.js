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
      let params = JSON.parse(event.data);
      if (params.action == "check_submit") {
        checkSubmit();
      }
      if(params.action  == 'return_result')
      {
        showResult(params.data);
      }
      if (params.action == "next_question") {
        let param = {};
        if (parseInt(count_question) == parseInt(params.stt)) {
          param = {
            action: "question_end"
          };
        } else {
          stt_start = parseInt(params.stt);
          $(".question_type").hide();
          $(".question_type.question_stt_" + parseInt(params.stt)).show();
          param = {
            action: "next_question_success"
          };
        }
        window.ReactNativeWebView.postMessage(JSON.stringify(param));
      }
      //alert(event.data);
    },
    false
  );
  $('.form_dien_tu input[type="button"]').on('click',function (e) {
    e.preventDefault();
    var $this = $(this);
    var form_active = $this.closest('.form_dien_tu');
    processDienTu(form_active);
  });
  //function hien thi ket qua tra ve
  function showResult(data) {
    if(data.question_type == 4)
    {
      //cau hoi trac nghiem
      showResultTracNghiem(data);
    }
    if(data.question_type == 3)
    {
      //cau hoi dien tu
      showResultDienTu(data);
    }
    if(data.question_type == 5)
    {
      //cau hoi dien tu doan van
      showResultDienTuDoanVan(data);
    }
  }
  function showResultTracNghiem(data) {
    
  }
  function showResultDienTu(data) {
    
  }
  function showResultDienTuDoanVan(data) {

  }
  //function kiem tra submit cau hoi
  function checkSubmit() {
    var form_active = $("#app").find(
      ".question_type[data-stt='" + stt_start + "']"
    );

    var question_type = form_active.find('input[name="question_type"]').val();

    if (parseInt(question_type) == 4) {
      //cau hoi trac nghiem
      processCauHoiTracNghiem(form_active);
    }
    if (parseInt(question_type) == 3) {
      //cau hoi dien tu
      processDienTu(form_active);
    }
    if (parseInt(question_type) == 5) {
      //cau hoi dien tu doan van
      processDienTuDoanVan(form_active);
    }
    //console.log(form_active);
  }
  function processDienTu(form_active) {
    var form_data = form_active.serializeArray(); console.log("xxx",form_data);
    let $all_answer = [];
    form_active.find(".input_answer").each(function() {
      if (jQuery.inArray($(this).attr("name"), $all_answer) == -1) {
        $all_answer.push($(this).attr("name"));
      }
    });
    let data = {};
    let check_answer = 0;
    let answers = {};
    for (let i = 0; i < form_data.length; i++) {
      var element = {};
      let name = form_data[i].name;

      if (jQuery.inArray(name, $all_answer) != -1) {
        if(form_data[i].value)
        {
          check_answer += 1;
        }
      }
      if (name.indexOf("answer") != -1) {
        var question_id = $(
            ".form_dien_tu input[name='" + name + "']"
        ).attr("data-question");
        answers[question_id] = form_data[i].value;
      }
      data[name] = form_data[i].value;
    }
    data["answers"] = answers;
    let params = {};
    if (check_answer == $all_answer.length) {
      params = {
        action: "submitQuestion",
        typeQuestion: "multiple_Choice",
        replyALl: true,
        data: data
      };
    } else {
      params = {
        action: "submitQuestion",
        typeQuestion: 4,
        replyALl: false,
        data: []
      };
    }
    console.log(params);
    window.ReactNativeWebView.postMessage(JSON.stringify(params));

  }
  function processDienTuDoanVan(form_active) {
    var form_data = form_active.serializeArray();
    let $all_answer = [];
    form_active.find(".input_answer").each(function() {
      if (jQuery.inArray($(this).attr("name"), $all_answer) == -1) {
        $all_answer.push($(this).attr("name"));
      }
    });
    let data = {};
    let check_answer = 0;
    let answers = {};
    for (let i = 0; i < form_data.length; i++) {
      var element = {};
      let name = form_data[i].name;

      if (jQuery.inArray(name, $all_answer) != -1) {
        if(form_data[i].value)
        {
          check_answer += 1;
        }
      }
      if (name.indexOf("txtLearnWord") != -1) {
        var question_id = $(
            ".form_dien_tu_doan_van .content input[name='" + name + "']"
        ).attr("data-question");
        var question_stt = $(
            ".form_dien_tu_doan_van .content input[name='" + name + "']"
        ).attr("data-stt");
        if(typeof answers[question_id] == 'undefined' || typeof answers[question_id] == undefined)
        {
          answers[question_id] = {};
        }
        answers[question_id][question_stt] = form_data[i].value;
      }
      data[name] = form_data[i].value;
    }
    data["answers"] = answers;

    let params = {};
    if (check_answer == $all_answer.length) {
      params = {
        action: "submitQuestion",
        typeQuestion: "multiple_Choice",
        replyALl: true,
        data: data
      };
    } else {
      params = {
        action: "submitQuestion",
        typeQuestion: 4,
        replyALl: false,
        data: []
      };
    }
    // alert($all_answer.length);
    window.ReactNativeWebView.postMessage(JSON.stringify(params));
  }
  function processCauHoiTracNghiem(form_active) {
    var form_data = form_active.serializeArray();

    let $all_answer = [];
    form_active.find("input[type=radio]").each(function() {
      if (jQuery.inArray($(this).attr("name"), $all_answer) == -1) {
        $all_answer.push($(this).attr("name"));
      }
    });
    let data = {};
    let check_answer = 0;
    let answers = {};
    for (let i = 0; i < form_data.length; i++) {
      var element = {};
      let name = form_data[i].name;

      if (jQuery.inArray(name, $all_answer) != -1) {
        check_answer += 1;
      }
      if (name.indexOf("answer") != -1) {
        var question_id = $(
          ".form_trac_nghiem .answer_radio.answer_" + form_data[i].value + ""
        ).attr("data-question");
        answers[question_id] = form_data[i].value;
      }
      data[name] = form_data[i].value;
    }
    data["answers"] = answers;

    let params = {};
    if (check_answer == $all_answer.length) {
      params = {
        action: "submitQuestion",
        typeQuestion: "multiple_Choice",
        replyALl: true,
        data: data
      };
    } else {
      params = {
        action: "submitQuestion",
        typeQuestion: 4,
        replyALl: false,
        data: []
      };
    }
    // alert($all_answer.length);
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
    // console.log(form_data);
    // // //
    // let $all_answer = [];
    // $(".form_trac_nghiem input[type=radio]").each(function() {
    //   if (jQuery.inArray($(this).attr("name"), $all_answer) == -1) {
    //     $all_answer.push($(this).attr("name"));
    //   }
    // });
    // let data = [];
    // let check_answer = 0;
    // let answers = {};
    // for (let i = 0; i < form_data.length; i++) {
    //   var element = {};
    //   let name = form_data[i].name;

    //   if (jQuery.inArray(name, $all_answer) != -1) {
    //     check_answer += 1;
    //   }
    //   if (name.indexOf("answer") != -1) {
    //     var question_id = $(
    //       ".form_trac_nghiem .answer_radio.answer_" + form_data[i].value + ""
    //     ).attr("data-question");
    //     answers[question_id] = form_data[i].value;
    //   }
    //   data[name] = form_data[i].value;
    // }
    // data["answers"] = answers;

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
  $(".form_trac_nghiem .list-action .icon-comment").on("click", function(e) {
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
  });
  //bookmark
  $(".form_trac_nghiem .list-action .icon-bookmark").on("click", function(e) {
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
  });
  //hien thi goi y
  $(".form_trac_nghiem .list-action .icon-sugess").on("click", function(e) {
    var $this = $(this);
    if ($this.hasClass("active")) {
      $this.removeClass("active");
      $this
        .closest(".form_trac_nghiem")
        .find(".question-app-trac-nghiem .content .sugess_all")
        .hide();
    } else {
      $this.addClass("active");
      $this
        .closest(".form_trac_nghiem")
        .find(".question-app-trac-nghiem .content .sugess_all")
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
