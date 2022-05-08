2018.01.12 修复记录

line372行中，
this.form_field_jq.hide().after(container_div); 改为 this.form_field_jq.addClass('chosen_hide').after(container_div);
修复表单提交中在下拉选项框使用JS验证插件验证判断时错误提示。

