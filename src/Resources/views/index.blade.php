<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Structure Kit</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --primary: #f9941f;
            --primary-dark: #ea580c;
            --secondary: #8b5cf6; 
            --bg-gradient: linear-gradient(135deg, #fff7ed 0%, #ffedd5 50%, #e0e7ff 100%);
            --surface: #ffffff;
            --text-main: #1f2937;
            --text-light: #6b7280;
            --border: #e5e7eb;
            --radius-lg: 16px;
            --radius-md: 8px;
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            --shadow-colored: 0 10px 25px -5px rgba(249, 148, 31, 0.25);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--bg-gradient);
            color: var(--text-main);
            min-height: 100vh;
            padding: 40px 20px;
            line-height: 1.6;
        }

        .container { max-width: 850px; margin: 0 auto; }

        h1 {
            text-align: center; font-size: 2.5rem; font-weight: 800; margin-bottom: 30px;
            background: linear-gradient(to right, var(--primary), #ec4899);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            letter-spacing: -1px;
        }

        .alert {
            background: #ecfdf5; color: #059669; padding: 15px; border-radius: var(--radius-md);
            margin-bottom: 20px; border: 1px solid #a7f3d0; text-align: center; font-weight: 600;
            transition: opacity 0.5s ease;
        }

        .box {
            background: var(--surface); border-radius: var(--radius-lg); padding: 30px;
            margin-bottom: 24px; box-shadow: var(--shadow); border: 1px solid rgba(255,255,255,0.6);
            position: relative; overflow: hidden;
        }

        .box::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .box-header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;
        }

        h3 { font-size: 1.1rem; font-weight: 700; display: flex; align-items: center; gap: 8px; margin: 0; }
        
        .toggle-btn {
            font-size: 0.8rem; font-weight: 700; color: var(--primary);
            background: #fff7ed; padding: 4px 10px; border-radius: 20px;
            cursor: pointer; border: 1px solid var(--primary); transition: all 0.2s;
        }
        .toggle-btn:hover { background: var(--primary); color: white; }

        label.field-label {
            display: block; font-size: 0.85rem; text-transform: uppercase;
            letter-spacing: 0.05em; font-weight: 700; color: var(--text-light); margin-bottom: 8px;
        }

        input[type="text"] {
            width: 100%; padding: 14px 18px; border-radius: var(--radius-md);
            border: 2px solid #f3f4f6; background: #f9fafb; font-size: 1rem;
            transition: all 0.2s ease; color: var(--text-main);
        }

        input[type="text"]:focus {
            outline: none; border-color: var(--primary); background: #fff;
            box-shadow: 0 0 0 4px rgba(249, 148, 31, 0.1);
        }

        .checkbox-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px;
        }

        /* STRICTLY HIDE CHECKBOXES */
        .chip-checkbox input[type="checkbox"],
        #hidden-inputs input[type="checkbox"] { 
            display: none !important; 
            visibility: hidden !important; 
            opacity: 0 !important; 
            position: absolute !important;
        }

        .chip-checkbox span {
            display: block; padding: 12px 15px; background: #f3f4f6; border-radius: var(--radius-md);
            text-align: center; font-size: 0.85rem; font-weight: 600; color: var(--text-light);
            cursor: pointer; transition: all 0.2s ease; border: 2px solid transparent; user-select: none;
        }

        .chip-checkbox input[type="checkbox"]:checked + span {
            background: #fff7ed; color: var(--primary-dark); border-color: var(--primary);
            box-shadow: 0 4px 6px -1px rgba(249, 148, 31, 0.1); transform: translateY(-2px);
        }

        .path-grid { display: grid; grid-template-columns: 1fr; gap: 20px; }
        .path-item { display: none; }
        .path-item.active { display: block; animation: fadeIn 0.3s ease; }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

        @media (min-width: 768px) { .path-grid { grid-template-columns: 1fr 1fr; } }

        pre {
            background: #1e1e2e; color: #a6accd; padding: 20px; border-radius: var(--radius-md);
            overflow-x: auto; font-family: 'Fira Code', monospace; font-size: 0.85rem; border-left: 4px solid var(--primary);
        }

        button.submit-btn {
            width: 100%; padding: 18px; border: none; border-radius: var(--radius-lg);
            background: linear-gradient(135deg, var(--primary) 0%, #fbbf24 100%);
            color: white; font-size: 1.1rem; font-weight: 700; cursor: pointer;
            transition: all 0.2s ease; box-shadow: var(--shadow-colored);
            text-transform: uppercase; letter-spacing: 0.05em;
        }

        button.submit-btn:hover { transform: translateY(-3px); box-shadow: 0 15px 30px -5px rgba(249, 148, 31, 0.4); }
    </style>
</head>

<body>

    <div class="container">
        <h1>Laravel Structure Kit</h1>

        @if(session('success'))
            <div class="alert" id="success-alert">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('structure-kit.generate') }}" id="structureForm">
            @csrf

            <div class="box">
                <label class="field-label">Base Model Name</label>
                <input type="text" name="name" id="name" placeholder="User" value="User">
            </div>

            <div class="box">
                <div class="box-header">
                    <h3>🛠 Generate Components</h3>
                    <div class="toggle-btn" id="bulkToggle" onclick="toggleAll()">Select All</div>
                </div>
                <div class="checkbox-grid">
                    <label class="chip-checkbox">
                        <input type="checkbox" name="patterns[]" value="model" data-targets="model" checked>
                        <span>Model</span>
                    </label>
                    <label class="chip-checkbox">
                        <input type="checkbox" name="patterns[]" value="controller" data-targets="controller" checked>
                        <span>Controller</span>
                    </label>
                    <label class="chip-checkbox">
                        <input type="checkbox" name="patterns[]" value="migration" data-targets="migration">
                        <span>Migration</span>
                    </label>
                    <label class="chip-checkbox">
                        <input type="checkbox" name="patterns[]" value="service_pattern" data-targets="service,service_interface" checked>
                        <span>Service Pattern</span>
                    </label>
                    <label class="chip-checkbox">
                        <input type="checkbox" name="patterns[]" value="repository_pattern" data-targets="repository,repository_interface" checked>
                        <span>Repository Pattern</span>
                    </label>
                </div>
                
                <div id="hidden-inputs" style="display: none !important;">
                    <input type="checkbox" name="components[]" value="model" id="real-model">
                    <input type="checkbox" name="components[]" value="controller" id="real-controller">
                    <input type="checkbox" name="components[]" value="migration" id="real-migration">
                    <input type="checkbox" name="components[]" value="service" id="real-service">
                    <input type="checkbox" name="components[]" value="service_interface" id="real-service_interface">
                    <input type="checkbox" name="components[]" value="repository" id="real-repository">
                    <input type="checkbox" name="components[]" value="repository_interface" id="real-repository_interface">
                </div>
            </div>

            <div class="box" id="paths-box">
                <h3>📂 Configuration Paths</h3>
                <div class="path-grid">
                    <div class="path-item" data-path-for="model"><label class="field-label">Model Path</label><input type="text" name="paths[model]" value="app/Models"></div>
                    <div class="path-item" data-path-for="controller"><label class="field-label">Controller Path</label><input type="text" name="paths[controller]" value="app/Http/Controllers"></div>
                    <div class="path-item" data-path-for="service_interface"><label class="field-label">Service Interface Path</label><input type="text" name="paths[service_interface]" value="app/Services/Contracts"></div>
                    <div class="path-item" data-path-for="service"><label class="field-label">Service Path</label><input type="text" name="paths[service]" value="app/Services"></div>
                    <div class="path-item" data-path-for="repository_interface"><label class="field-label">Repository Interface Path</label><input type="text" name="paths[repository_interface]" value="app/Repositories/Contracts"></div>
                    <div class="path-item" data-path-for="repository"><label class="field-label">Repository Path</label><input type="text" name="paths[repository]" value="app/Repositories"></div>
                </div>
            </div>

            <div class="box">
                <h3>👀 File Preview</h3>
                <pre id="preview"></pre>
            </div>

            <button type="submit" class="submit-btn">🚀 Generate Files</button>
        </form>
    </div>

    <script>
        const form = document.getElementById('structureForm');
        const preview = document.getElementById('preview');
        const alertBox = document.getElementById('success-alert');
        const toggleBtn = document.getElementById('bulkToggle');

        if (alertBox) {
            setTimeout(() => {
                alertBox.style.opacity = '0';
                setTimeout(() => alertBox.remove(), 500);
            }, 5000);
        }

        function toggleAll() {
            const patternCheckboxes = document.querySelectorAll('input[name="patterns[]"]');
            const allChecked = Array.from(patternCheckboxes).every(cb => cb.checked);
            patternCheckboxes.forEach(cb => cb.checked = !allChecked);
            updateState();
        }

        function updateState() {
            const name = document.getElementById('name').value || 'Sample';
            const patternCheckboxes = document.querySelectorAll('input[name="patterns[]"]');
            
            const allChecked = Array.from(patternCheckboxes).every(cb => cb.checked);
            toggleBtn.textContent = allChecked ? "Deselect All" : "Select All";

            document.querySelectorAll('#hidden-inputs input').forEach(i => i.checked = false);
            document.querySelectorAll('.path-item').forEach(i => i.classList.remove('active'));

            patternCheckboxes.forEach(pc => {
                if (pc.checked) {
                    const targets = pc.dataset.targets.split(',');
                    targets.forEach(t => {
                        const realInput = document.getElementById('real-' + t);
                        if(realInput) realInput.checked = true;
                        const pathDiv = document.querySelector(`[data-path-for="${t}"]`);
                        if(pathDiv) pathDiv.classList.add('active');
                    });
                }
            });

            const activePaths = document.querySelectorAll('.path-item.active');
            document.getElementById('paths-box').style.display = activePaths.length > 0 ? 'block' : 'none';

            const data = new FormData(form);
            let tree = '';
            const map = {
                model: name + '.php',
                controller: name + 'Controller.php',
                service_interface: name + 'ServiceInterface.php',
                service: name + 'Service.php',
                repository_interface: name + 'RepositoryInterface.php',
                repository: name + 'Repository.php',
            };

            const selectedComponents = data.getAll('components[]');
            for (const [key, file] of Object.entries(map)) {
                if (selectedComponents.includes(key)) {
                    const path = data.get(`paths[${key}]`);
                    if (path) tree += path + '/' + file + "\n";
                }
            }

            if (selectedComponents.includes('migration')) {
                tree += "database/migrations/create_" + name.toLowerCase() + "_table.php\n";
            }

            preview.textContent = tree || 'No files selected';
        }

        form.addEventListener('input', updateState);
        updateState(); 
    </script>
</body>
</html>