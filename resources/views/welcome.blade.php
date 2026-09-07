<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Task</title>
    <script src="{{ asset('jquery.min.js') }}"></script>
    <script src="{{ asset('app.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body style="background-color: #edf2f7; margin: 0; padding: 20px; font-family: sans-serif;">
<div style="max-width: 800px; margin: 40px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <h2 style="color: #333; margin-bottom: 20px;">Employees (CSV)</h2>
    <form id="csvForm" enctype="multipart/form-data">
        <div style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 4px;">
            <input type="file" id="csvFile" name="file" style="font-size: 16px;" accept=".csv" />
            <div id="loadingStatus" style="margin-top: 10px; color: #666; font-style: italic; display: none;">Loading...</div>
        </div>
    </form>
    <div id="resultContainer" style="display: none;">
        <h3 style="color: #2b6cb0; margin-top: 30px;">Result</h3>
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px; background: #fff;">
            <thead>
            <tr style="background: #2b6cb0; color: white;">
                <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Employee ID #1</th>
                <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Employee ID #2</th>
                <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Project ID</th>
                <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Days worked</th>
            </tr>
            </thead>
            <tbody id="resultGrid"></tbody>
        </table>
    </div>

    <div id="noResult" style="display: none; color: #c53030; background: #fff5f5; padding: 10px; border-radius: 4px; margin-top: 20px;">
        There are no results.
    </div>
</div>
</body>
</html>
