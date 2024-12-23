"use strict";
var KTAuthNewPassword = (function () {
  var t,
    e,
    r,
    o,
    a = function () {
      return 100 === o.getScore();
    };
  return {
    init: function () {
      (t = document.querySelector("#kt_new_password_form")),
        (e = document.querySelector("#kt_new_password_submit")),
        (o = KTPasswordMeter.getInstance(
          t.querySelector('[data-kt-password-meter="true"]')
        )),
        (r = FormValidation.formValidation(t, {
          fields: {
            new: {
              validators: {
                notEmpty: { message: "The password is required" },
                callback: {
                  message: "Please enter valid password",
                  callback: function (t) {
                    if (t.value.length > 0) return a();
                  },
                },
              },
            },
            new_confirm: {
              validators: {
                notEmpty: { message: "The password confirmation is required" },
                identical: {
                  compare: function () {
                    return t.querySelector('[name="new"]').value;
                  },
                  message: "The password and its confirm are not the same",
                },
              },
            },
            toc: {
              validators: {
                notEmpty: {
                  message: "You must accept the terms and conditions",
                },
              },
            },
          },
          plugins: {
            trigger: new FormValidation.plugins.Trigger({
              event: { new: !1 },
            }),
            bootstrap: new FormValidation.plugins.Bootstrap5({
              rowSelector: ".fv-row",
              eleInvalidClass: "",
              eleValidClass: "",
            }),
          },
        })),
        e.addEventListener("click", function (a) {
          a.preventDefault(),
            r.revalidateField("new"),
            r.validate().then(function (r) {
              "Valid" == r
                ? (e.setAttribute("data-kt-indicator", "on"),
                  (e.disabled = !0),
                  setTimeout(function () {
                    t.submit();
                    
                    e.removeAttribute("data-kt-indicator"),
                      (e.disabled = !1),
                      Swal.fire({
                        text: "You have successfully reset your password!",
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: { confirmButton: "btn btn-primary" },
                      }).then(function (e) {
                        if (e.isConfirmed) {
                          (t.querySelector('[name="new"]').value = ""),
                            (t.querySelector('[name="new_confirm"]').value = ""),
                            o.reset();
                          var r = t.getAttribute("data-kt-redirect-url");
                          r && (location.href = r);
                        }
                      });
                  }, 1500))
                : Swal.fire({
                    text: "Sorry, looks like there are some errors detected, please try again.",
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: { confirmButton: "btn btn-primary" },
                  });
            });
        }),
        t.querySelector('input[name="new"]')
          .addEventListener("input", function () {
            this.value.length > 0 &&
              r.updateFieldStatus("new", "NotValidated");
          });
    },
  };
})();
KTUtil.onDOMContentLoaded(function () {
  KTAuthNewPassword.init();
});
