(function ($) {
    "use strict";

    $(function () {
        // 处理投票
        $(".vote-button").on("click", function (e) {
            e.preventDefault();
            var $button = $(this);
            var debateId = $button.data("debate-id");
            var voteType = $button.data("vote");

            $.ajax({
                url: debate_topics_ajax.ajax_url,
                type: "POST",
                data: {
                    action: "debate_topics_vote",
                    debate_id: debateId,
                    vote_type: voteType,
                    nonce: debate_topics_ajax.nonce,
                },
                success: function (response) {
                    if (response.success) {
                        // 更新投票统计
                        var $progressBar = $button.closest(".debate-voting").find(".debate-progress-bar");
                        var forPercentage = (response.data.for_votes / (response.data.for_votes + response.data.against_votes)) * 100;
                        var againstPercentage = 100 - forPercentage;
                        $progressBar
                            .find(".for-bar")
                            .css("width", forPercentage + "%")
                            .text("赞成 " + forPercentage.toFixed(2) + "%");
                        $progressBar
                            .find(".against-bar")
                            .css("width", againstPercentage + "%")
                            .text("反对 " + againstPercentage.toFixed(2) + "%");
                        $button
                            .closest(".debate-voting")
                            .find("p")
                            .text("赞成票数: " + response.data.for_votes + " | 反对票数: " + response.data.against_votes);
                        // 禁用投票按钮，防止重复投票
                        $(".vote-button").prop("disabled", true);
                    } else {
                        alert(response.data);
                    }
                },
                error: function () {
                    alert("投票失败，请稍后再试。");
                },
            });
        });

        // 处理提交观点
        $(".argument-form").on("submit", function (e) {
            e.preventDefault();
            var $form = $(this);
            var debateId = $form.find('input[name="debate_id"]').val();
            var argumentType = $form.data("type");
            var argumentContent = $form.find('textarea[name="argument_content"]').val();

            $.ajax({
                url: debate_topics_ajax.ajax_url,
                type: "POST",
                data: {
                    action: "debate_topics_submit_argument",
                    debate_id: debateId,
                    argument_type: argumentType,
                    argument_content: argumentContent,
                    nonce: debate_topics_ajax.nonce,
                },
                success: function (response) {
                    if (response.success) {
                        // 清空表单并刷新页面以显示新观点
                        $form.find("textarea").val("");
                        location.reload();
                    } else {
                        alert(response.data);
                    }
                },
            });
        });
    });
})(jQuery);
