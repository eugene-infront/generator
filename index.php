<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MRZ Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5 mb-5">
    <h2 class="text-center">Passport MRZ Generator</h2>

    <div class="row d-flex g-3">
        <div class="col-6">
            <form id="mrzForm" class='card p-4 mt-3'>
                <div class="mb-3">
                    <label for="passportNumber" class="form-label">Passport Number</label>
                    <input type="text" class="form-control" id="passportNumber" name="passport_number" required>
                </div>

                <div class="mb-3">
                    <label for="birthDate" class="form-label">Birth Date (YYMMDD)</label>
                    <input type="text" class="form-control" id="birthDate" name="birth_date" required>
                </div>

                <div class="mb-3">
                    <label for="expiryDate" class="form-label">Expiry Date (YYMMDD)</label>
                    <input type="text" class="form-control" id="expiryDate" name="expiry_date" required>
                </div>

                <!-- Country selection -->
                <div class="mb-3">
                    <label for="countrySelect" class="form-label">Country</label>
                    <select class="form-control select2 w-100" id="countrySelect" name="country_name" required>
                        <option value="">Search Country...</option>
                    </select>
                </div>

                <!-- Hidden ISO 3 Country Code -->
                <input type="hidden" id="countryCode" name="country_code">

                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-control" id="gender" name="gender">
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Generate MRZ</button>
            </form>
        </div>

        <div class="col-6">
            <div class="card p-4 mt-3" style="min-height: 590px">
                <h4>Generated MRZ:</h4>
                <pre id="mrzResult"></pre>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
        const countryList = {
        "Afghanistan": "AFG",
        "Albania": "ALB",
        "Algeria": "DZA",
        "Argentina": "ARG",
        "Australia": "AUS",
        "Bangladesh": "BGD",
        "Brazil": "BRA",
        "Canada": "CAN",
        "China": "CHN",
        "Denmark": "DNK",
        "Egypt": "EGY",
        "France": "FRA",
        "Germany": "DEU",
        "India": "IND",
        "Indonesia": "IDN",
        "Italy": "ITA",
        "Japan": "JPN",
        "Malaysia": "MYS",
        "Mexico": "MEX",
        "Netherlands": "NLD",
        "Pakistan": "PAK",
        "Russia": "RUS",
        "Saudi Arabia": "SAU",
        "South Korea": "KOR",
        "Spain": "ESP",
        "Thailand": "THA",
        "United Kingdom": "GBR",
        "United States": "USA",
        "Vietnam": "VNM"
    };

    $(".select2").select2({
        placeholder: "Search Country...",
        allowClear: true
    });

    // Populate the dropdown list
    const countrySelect = $("#countrySelect");
    $.each(countryList, function(country, code) {
        countrySelect.append(new Option(country, code));
    });

    // Auto-fill the hidden country code input
    $("#countrySelect").on("change", function() {
        $("#countryCode").val(this.value);
    });

    // Set default country as Indonesia
    $("#countrySelect").val("JPN").trigger("change");
    $("#mrzForm").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "generate_mrz.php",
            data: $(this).serialize(),
            success: function(response) {
                $("#mrzResult").text(response);
            }
        });
    });
</script>

</body>
</html>
