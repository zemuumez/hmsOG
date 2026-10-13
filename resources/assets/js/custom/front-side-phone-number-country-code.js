document.addEventListener("DOMContentLoaded", loadFrontPhoneNumberCountryCodeData);

function loadFrontPhoneNumberCountryCodeData() {
    Lang.setLocale($(".userCurrentLanguage").val());

    if (!$(".phoneNumber").length) {
        return;
    }

    let input = document.querySelector(".phoneNumber");
    let errorMsg = document.querySelector(".error-msg");
    let validMsg = document.querySelector(".valid-msg");

    let errorMap = [
        Lang.get("js.invalid_number"),
        Lang.get("js.invalid_country_code"),
        Lang.get("js.too_short"),
        Lang.get("js.too_long"),
        Lang.get("js.invalid_number"),
    ];

    let intl = window.intlTelInput(input, {
        initialCountry: "auto",
        separateDialCode: true,
        geoIpLookup: function (success) {
            $.get("https://ipinfo.io", function () {}, "jsonp").always(function (resp) {
                let countryCode = resp && resp.country ? resp.country : "in";
                success(countryCode);
            });
        },
        utilsScript: $(".utilsScript").val(),
    });

    function reset() {
        input.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("d-none");
        validMsg.classList.add("d-none");
    }

    function updatePrefixCode() {
        let countryData = intl.getSelectedCountryData();

        if (countryData && countryData.dialCode) {
            $(".prefix_code").val("+" + countryData.dialCode);
        }
    }

    input.addEventListener("blur", function () {
        reset();

        if (input.value.trim()) {
            if (intl.isValidNumber()) {
                validMsg.classList.remove("d-none");
            } else {
                input.classList.add("error");

                let errorCode = intl.getValidationError();
                if (errorCode < 0 || errorCode >= errorMap.length) {
                    errorCode = 0;
                }

                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("d-none");
            }
        }

        updatePrefixCode();
    });

    input.addEventListener("change", reset);
    input.addEventListener("keyup", reset);

    input.addEventListener("keyup", updatePrefixCode);
    input.addEventListener("change", updatePrefixCode);
    input.addEventListener("countrychange", updatePrefixCode);

    setTimeout(function () {
        updatePrefixCode();
    }, 300);

    $("form").on("submit", function () {
        updatePrefixCode();
    });

    let phoneNumber = $(".phoneNumber").val();
    if (phoneNumber) {
        $(".phoneNumber").val(phoneNumber.replace(/\s/g, ""));
    }
}