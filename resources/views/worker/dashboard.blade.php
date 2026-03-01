<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Mobile Dashboard Only</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,700;1,400&family=Dancing+Script:wght@600&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { height: 100vh; background: #0f0f0f; color: #e5e7eb; display: flex; align-items: center; justify-content: center; font-family: Consolas, Menlo, monospace; }

.error { width: 100%; max-width: 760px; padding: 48px; }
.error h1 { font-size: 64px; margin-bottom: 6px; }
.error h2 { font-size: 20px; font-weight: normal; margin-bottom: 20px; }
.error p { font-size: 14px; color: #9ca3af; line-height: 1.7; margin-bottom: 28px; }
.error ul { font-size: 13px; color: #6b7280; margin-bottom: 36px; padding-left: 18px; }
.error button { font-family: inherit; background: #1a1a1a; border: 1px solid #333; color: #e5e7eb; padding: 10px 22px; cursor: pointer; }

body.card-mode { font-family: 'Crimson Text', serif; background: #111; color: #fff; justify-content: flex-start; padding-top: 50px; }
.handwritten { font-family: 'Dancing Script', cursive; }
.perspective { perspective: 1500px; }
</style>
</head>
<body>

<div class="error" id="error">
  <h1>⚠️</h1>
  <h2>Dashboard Unavailable</h2>
  <p>This dashboard is available for mobile devices only.</p>
  <ul>
    <li>Please access this dashboard from a smartphone or tablet.</li>
    <li>Desktop or laptop view is not supported.</li>
    <li>Try again using a mobile device.</li>
  </ul>
  <button onclick="location.reload()">Refresh</button>
</div>

</body>
</html>