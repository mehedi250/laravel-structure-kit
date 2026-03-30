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
            --success: #22c55e;
            --bg-gradient: linear-gradient(135deg, #f8fafc 0%, #eff6ff 100%);
            --surface: rgba(255, 255, 255, 0.9);
            --text-main: #1e293b;
            --text-light: #64748b;
            --border: #e2e8f0;
            --radius-lg: 12px;
            --radius-md: 8px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
            --bg-gradient: linear-gradient(135deg, #6366f1 0%, #f9941f 100%);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--bg-gradient);
            color: var(--text-main);
            min-height: 100vh;
            padding: 20px;
            line-height: 1.5;
        }

        .container { max-width: 1200px; margin: 0 auto; }

        header { text-align: center; margin-bottom: 30px; }
        h1 {
font-size: 2.5rem;
    font-weight: 800;
    /* Use colors that are slightly different from the background */
    background: linear-gradient(to right, #ffffff, #e2e8f0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    /* This white glow saves the readability */
    filter: drop-shadow(0 2px 15px rgba(255, 255, 255, 0.3));
        }

        /* --- LAYOUT GRID (Equal Height) --- */
        .layout-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
        }

        @media (min-width: 900px) {
            .layout-grid {
                /* 350px left, rest right. 'stretch' ensures equal height */
                grid-template-columns: 350px 1fr;
                align-items: stretch; 
            }
        }

        /* --- PANEL STYLING --- */
        .panel {
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            height: 100%;
            backdrop-filter: blur(10px);
        }

        .panel-header {
            padding: 16px 20px;
            background: #f8fafc;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        }
        .panel-header h2 {
            font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;
            color: var(--text-light); font-weight: 700; margin: 0;
        }

        .panel-body {
            padding: 20px;
            flex: 1; /* Pushes content to fill height */
            display: flex;
            flex-direction: column;
        }

        /* --- LEFT SIDE COMPONENTS --- */
        label.field-label {
            display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
            color: var(--text-light); margin-bottom: 6px; letter-spacing: 0.05em;
        }

        input[type="text"] {
            width: 100%; padding: 10px 12px; border-radius: var(--radius-md);
            border: 1px solid var(--border); background: #fff; font-size: 0.9rem;
            color: var(--text-main); transition: all 0.2s;
        }
        input[type="text"]:focus {
            outline: none; border-color: var(--primary); 
            box-shadow: 0 0 0 3px rgba(249, 148, 31, 0.1);
        }

        .input-group { margin-bottom: 24px; }

        .checkbox-list { display: flex; flex-direction: column; gap: 8px; }
        
        .chip-checkbox span {
            display: flex; align-items: center; justify-content: space-between;
            padding: 12px 16px; background: #f8fafc; border-radius: var(--radius-md);
            font-size: 0.9rem; font-weight: 500; color: var(--text-light);
            cursor: pointer; border: 1px solid transparent; transition: all 0.2s;
        }
        .chip-checkbox input:checked + span {
            background: #fff7ed; color: var(--primary-dark); border-color: var(--primary);
            font-weight: 600;
        }

        .chip-checkbox input:checked + span::after {
            content: '✓'; font-weight: bold;
        }
        .chip-checkbox input[type="checkbox"] { display: none; }

        .toggle-btn {
            font-size: 0.75rem; color: var(--primary); cursor: pointer; font-weight: 600; float: right;
        }

        /* --- RIGHT SIDE COMPONENTS --- */
        
        /* Path Grid with Labels */
        .path-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
            margin-bottom: 24px;
        }
        @media (min-width: 1200px) { .path-grid { grid-template-columns: 1fr 1fr; } }

        .path-item { 
            /* display: none;  */
            background: #f8fafc;
            padding: 10px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
        }
        .path-item.active { 
            display: block; 
            /* animation: fadeIn 0.3s ease;  */
        }

        .path-label {
            font-size: 0.7rem; font-weight: 700; color: var(--text-light);
            margin-bottom: 4px; display: block; text-transform: uppercase;
            display: flex; align-items: center; justify-content: space-between;
        }

        /* .path-item.active .path-label::after{
            content: "✓";
            color: var(--success);
            font-weight: bold;
            font-size: 0.7rem;
        } */

        .path-input-clean {
            width: 100%; border: none; background: transparent; 
            font-family: 'Fira Code', monospace; font-size: 0.85rem; color: var(--text-main);
            padding: 0;
        }
        .path-input-clean:focus { outline: none; }

        /* Terminal Preview (Flex Grow to fill height) */
        .terminal-container {
            display: flex; flex-direction: column; flex-grow: 1; /* Fills remaining space */
            min-height: 200px;
        }

        .terminal-window {
            background: #1e1e2e; border-radius: var(--radius-md);
            overflow: hidden; border: 1px solid #333;
            flex-grow: 1; display: flex; flex-direction: column;
        }
        .terminal-header {
            background: #2a2a3c; padding: 8px 12px; display: flex; gap: 6px; flex-shrink: 0;
        }
        .dot { width: 10px; height: 10px; border-radius: 50%; }
        .dot.red { background: #ff5f56; }
        .dot.yellow { background: #ffbd2e; }
        .dot.green { background: #27c93f; }

        pre {
            color: #a6accd; padding: 15px; overflow: auto;
            font-family: 'Fira Code', monospace; font-size: 0.85rem; line-height: 1.6;
            margin: 0; height: 100%;
        }

        button.submit-btn {
            width: 100%; padding: 16px; border: none; border-radius: var(--radius-md);
            background: var(--text-main); color: white; font-size: 1rem; font-weight: 700;
            cursor: pointer; margin-top: auto; 
        }
        button.submit-btn:hover { background: var(--primary); }

        .alert {
            background: #ecfdf5; color: #059669; padding: 15px; border-radius: var(--radius-md);
            margin-bottom: 20px; border: 1px solid #a7f3d0; text-align: center; font-weight: 600;
            transition: opacity 0.5s ease;
        }
        
        .alert.error {
            background: #fef2f2; color: #dc2626; border-color: #fecaca;
        }

        /* --- FOOTER --- */
        .app-footer {
            margin-top: 40px;
            padding: 16px 20px;
            border-top: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(6px);
        }

        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
            justify-content: space-between;
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .footer-left strong {
            color: var(--text-main);
            font-weight: 700;
        }

        .footer-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-right a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .footer-right a:hover {
            text-decoration: underline;
        }

        .dot-sep {
            opacity: 0.5;
        }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>

<body>

    <div class="container">
        <header>
            <h1>Laravel Structure Kit</h1>
        </header>

        <div id="js-messages"></div>
        @if(session('success'))
            <div class="alert" id="success-alert">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('structure-kit.generate') }}" id="structureForm">
            @csrf

            <div class="layout-grid">
                
                <div class="panel">
                    <div class="panel-header">
                        <h2>Configuration</h2>
                        <div style="font-size: 0.8rem; color: var(--text-light);">{{ $version }}</div>
                    </div>
                    <div class="panel-body">
                        
                        <div class="input-group">
                            <label class="field-label">Base Model Name</label>
                            <input type="text" name="name" id="name" placeholder="e.g. Product" value="Product">
                        </div>

                        <div class="input-group" style="flex-grow: 1;">
                            <label class="field-label">
                                Components 
                                <span class="toggle-btn" id="bulkToggle" onclick="toggleAll()">Select All</span>
                            </label>
                            
                            <div class="checkbox-list">
                                <label class="chip-checkbox">
                                    <input type="checkbox" name="patterns[]" value="model" data-targets="model" checked>
                                    <span>Model</span>
                                </label>
                                <label class="chip-checkbox">
                                    <input type="checkbox" name="patterns[]" value="controller" data-targets="controller" checked>
                                    <span>Controller</span>
                                </label>
                                <label class="chip-checkbox">
                                    <input type="checkbox" name="patterns[]" value="migration" data-targets="migration" checked>
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
                        </div>

                        <div class="input-group" style="margin-bottom: 24px;">
                            <label class="" style="display: inline-block;">
                                <input type="checkbox" id="remember-paths">
                                <span>Remember current path</span>
                            </label>
                        </div>

                        <button type="submit" class="submit-btn">🚀 Generate Files</button>

                        <div id="hidden-inputs" style="display:none;">
                            <input type="checkbox" name="components[]" value="model" id="real-model">
                            <input type="checkbox" name="components[]" value="controller" id="real-controller">
                            <input type="checkbox" name="components[]" value="migration" id="real-migration">
                            <input type="checkbox" name="components[]" value="service" id="real-service">
                            <input type="checkbox" name="components[]" value="service_interface" id="real-service_interface">
                            <input type="checkbox" name="components[]" value="repository" id="real-repository">
                            <input type="checkbox" name="components[]" value="repository_interface" id="real-repository_interface">
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-header">
                        <h2>File Path Preview</h2>
                        <button type="button" id="refreshPathsBtn" style="background: none; border: none; color: var(--primary); cursor: pointer; font-size: 0.8rem; font-weight: 600;">Refresh Path</button>
                    </div>
                    <div class="panel-body">
                        
                        <div id="paths-box">
                            <label class="field-label" style="margin-bottom: 10px;">Customize Namespaces</label>
                            <div class="path-grid">
                                <div class="path-item" data-path-for="model">
                                    <span class="path-label">Model</span>
                                    <input class="path-input-clean" type="text" name="paths[model]" value="app/Models">
                                </div>
                                <div class="path-item" data-path-for="controller">
                                    <span class="path-label">Controller</span>
                                    <input class="path-input-clean" type="text" name="paths[controller]" value="app/Http/Controllers">
                                </div>
                                <div class="path-item" data-path-for="service_interface">
                                    <span class="path-label">Service Interface</span>
                                    <input class="path-input-clean" type="text" name="paths[service_interface]" value="app/Services/Contracts">
                                </div>
                                <div class="path-item" data-path-for="service">
                                    <span class="path-label">Service Class</span>
                                    <input class="path-input-clean" type="text" name="paths[service]" value="app/Services/Implementations">
                                </div>
                                <div class="path-item" data-path-for="repository_interface">
                                    <span class="path-label">Repository Interface</span>
                                    <input class="path-input-clean" type="text" name="paths[repository_interface]" value="app/Repositories/Contracts">
                                </div>
                                <div class="path-item" data-path-for="repository">
                                    <span class="path-label">Repository Class</span>
                                    <input class="path-input-clean" type="text" name="paths[repository]" value="app/Repositories/Eloquent">
                                </div>
                            </div>
                        </div>

                        <div class="terminal-container">
                            <label class="field-label">Structure Output</label>
                            <div class="terminal-window">
                                <div class="terminal-header">
                                    <div class="dot red"></div>
                                    <div class="dot yellow"></div>
                                    <div class="dot green"></div>
                                </div>
                                <pre id="preview"></pre>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </form>
    </div>
    <footer class="app-footer">
        <div class="footer-inner">
            <div class="footer-left">
                <strong>Laravel Structure Kit</strong>
                <span>— UI + CLI Architecture Generator</span>
            </div>

            <div class="footer-right">
                <span>{{ $version }}</span>
                <span class="dot-sep">•</span>
                <a href="https://github.com/mehedi250/laravel-structure-kit" target="_blank">
                    GitHub
                </a>
                <span class="dot-sep">•</span>
                <span>© {{ date('Y') }}</span>
            </div>
        </div>
    </footer>

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

            generateTree(name);
        }

        function generateTree(name) {
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
                    if (path) tree += `+ ${path}/${file}\n`;
                }
            }

            if (selectedComponents.includes('migration')) {
                const date = new Date().toISOString().slice(0,10).replace(/-/g,'_');
                tree += `+ database/migrations/${date}_000000_create_${name.toLowerCase()}_table.php\n`;
            }

            preview.textContent = tree || '// No components selected';
        }

        form.addEventListener('input', updateState);

        // Task 3: On page load, retrieve saved paths
        const rememberCheckbox = document.getElementById('remember-paths');
        const savedRemember = localStorage.getItem('structure_kit_remember');
        
        if (savedRemember === 'true') {
            rememberCheckbox.checked = true;
            const savedPaths = localStorage.getItem('structure_kit_paths');
            if (savedPaths) {
                try {
                    const parsedPaths = JSON.parse(savedPaths);
                    for (const [key, value] of Object.entries(parsedPaths)) {
                        const inputs = document.getElementsByName(key);
                        if (inputs.length > 0) {
                            inputs[0].value = value;
                        }
                    }
                } catch (e) {
                    console.error('Failed to parse saved paths', e);
                }
            }
        }

        // Task 2: Refresh File Paths
        document.getElementById('refreshPathsBtn').addEventListener('click', () => {
            const defaultPaths = {
                model: "app/Models",
                controller: "app/Http/Controllers",
                service_interface: "app/Services/Contracts",
                service: "app/Services/Implementations",
                repository_interface: "app/Repositories/Contracts",
                repository: "app/Repositories/Eloquent"
            };
            
            for (const [key, value] of Object.entries(defaultPaths)) {
                const inputs = document.getElementsByName(`paths[${key}]`);
                if (inputs.length > 0) {
                    inputs[0].value = value;
                }
            }
            
            localStorage.removeItem('structure_kit_paths');
            localStorage.setItem('structure_kit_remember', 'false');
            document.getElementById('remember-paths').checked = false;
            updateState();
        });

        function showMessage(msg, type) {
            const container = document.getElementById('js-messages');
            container.innerHTML = '';
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert ' + type;
            alertDiv.textContent = msg;
            container.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.style.opacity = '0';
                setTimeout(() => alertDiv.remove(), 500);
            }, 5000);
        }

        // Task 1: Fetch API Form Submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = form.querySelector('.submit-btn');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.innerHTML = '🚀 Generating...';
            submitBtn.disabled = true;

            const data = new FormData(form);
            
            // Task 3: Save paths if checkbox is selected
            if (rememberCheckbox.checked) {
                const pathsToSave = {};
                for (const [key, value] of data.entries()) {
                    if (key.startsWith('paths[')) {
                        pathsToSave[key] = value;
                    }
                }
                localStorage.setItem('structure_kit_paths', JSON.stringify(pathsToSave));
                localStorage.setItem('structure_kit_remember', 'true');
            } else {
                localStorage.removeItem('structure_kit_paths');
                localStorage.setItem('structure_kit_remember', 'false');
            }

            fetch(form.action, {
                method: 'POST',
                body: data,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                const isJson = response.headers.get('content-type')?.includes('application/json');
                let resData = null;
                if (isJson) {
                    resData = await response.json();
                } else {
                    resData = await response.text();
                }
                
                if (response.ok) {
                    showMessage(resData.message || 'Structure generated successfully!', 'success');
                } else {
                    let errorMessage = 'Something went wrong. Please try again.';
                    if (isJson) {
                        if (resData.errors) {
                            errorMessage = Object.values(resData.errors)
                                                 .map(errs => errs.join(' '))
                                                 .join('<br>');
                        } else if (resData.message) {
                            errorMessage = resData.message;
                        }
                    }
                    
                    const container = document.getElementById('js-messages');
                    container.innerHTML = '';
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert error';
                    alertDiv.innerHTML = '<strong>Error:</strong><br>' + errorMessage;
                    container.appendChild(alertDiv);
                    
                    setTimeout(() => {
                        alertDiv.style.opacity = '0';
                        setTimeout(() => alertDiv.remove(), 500);
                    }, 6000);
                }
            })
            .catch(error => {
                showMessage('Network Error: ' + error.message, 'error');
            })
            .finally(() => {
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
            });
        });

        updateState(); 
    </script>
</body>
</html>