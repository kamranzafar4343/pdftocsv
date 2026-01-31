<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Free Bank Statement Converter</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f9fafb;
        }

        header {
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
        }

        .logo {
            font-weight: bold;
            color: #2563eb;
        }

        .hero {
            text-align: center;
            padding: 60px 20px;
        }

        .hero h1 {
            font-size: 36px;
        }

        .hero p {
            color: #555;
        }

        .upload-box {
            margin: 40px auto;
            width: 60%;
            background: #f3f4f6;
            padding: 50px;
            border-radius: 12px;
            animation: fadeIn 1s ease-in-out;
        }

        .upload-btn {
            background: #4f46e5;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .upload-btn:hover {
            transform: scale(1.05);
        }

        input[type=file] {
            display: none;
        }

        .features {
            display: flex;
            justify-content: center;
            gap: 50px;
            margin-top: 50px;
        }

        .feature {
            text-align: center;
            animation: slideUp 1s ease;
        }

        .cards {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 60px 0;
        }

        .card {
            border: 1px solid #ddd;
            padding: 20px;
            width: 220px;
            border-radius: 10px;
            background: #fff;
            transition: transform .3s;
        }

        .card:hover {
            transform: translateY(-8px);
        }

        .free {
            border: 2px solid #4f46e5;
        }

        .status {
            margin-top: 20px;
            font-weight: bold;
        }

        @keyframes fadeIn {
            from {opacity:0;}
            to {opacity:1;}
        }

        @keyframes slideUp {
            from {transform: translateY(40px); opacity:0;}
            to {transform: translateY(0); opacity:1;}
        }
    </style>
</head>
<body>

<header>
    <div class="logo">BANK STATEMENT CONVERTER</div>
    <div>Free Tool</div>
</header>

<section class="hero">
    <h1>Bank statement converter</h1>
    <p>Convert your PDF bank statements into clean CSV files. 100% Free.</p>

    <div class="upload-box">
        <label for="pdfInput" class="upload-btn">Click here to convert a PDF</label>
        <input type="file" id="pdfInput" accept="application/pdf" onchange="convertPdf()">

        <div class="status" id="status"></div>
    </div>

    <div class="features">
        <div class="feature">🔐 Secure</div>
        <div class="feature">🏦 Institutional</div>
        <div class="feature">🎯 Accurate</div>
    </div>


    </div>
</section>

<script>
async function convertPdf() {
    const input = document.getElementById('pdfInput');
    const status = document.getElementById('status');

    if (!input.files.length) return;

    const formData = new FormData();
    formData.append('pdf', input.files[0]);

    status.innerText = "Converting... ⏳";

    const response = await fetch("{{ route('pdf.convert') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    });

    if (!response.ok) {
        status.innerText = "Conversion failed ❌";
        return;
    }

    const blob = await response.blob();
    const url = window.URL.createObjectURL(blob);

    status.innerHTML = `
        ✅ Done! <br><br>
        <a href="${url}" download="statement.csv" style="color:#2563eb;">Download CSV</a>
    `;
}
</script>

</body>
</html>
