# Laravel Structure Kit

Laravel Structure Kit is a **UI-first architecture & file structure generator for Laravel**.
It allows developers to **design, preview, and generate clean architecture visually** — before a single file is written.

This package is built for developers who care about **scalability, maintainability, and clean project structure**.

---

## 🚀 Why Laravel Structure Kit?

Laravel grows fast — and so does technical debt.

Laravel Structure Kit helps you:

* Design architecture **before generating files**
* Maintain **consistent, scalable structure**
* Avoid namespace & folder mistakes
* Enforce clean architecture patterns
* Generate code with confidence

> Think of it as **“Architecture first, code second.”**

---

## ✨ Core Features

### 🖥️ UI-Based Architecture Generator (Main Highlight)

* Visual file & architecture generator
* Select components with checkboxes
* Fully customizable paths (no fixed folders)
* Live preview of generated file tree
* Auto-generated namespaces from paths
* Shows **only newly generated files**
* No guessing — preview everything first

### 🧩 Supported Components

* Model
* Controller
* Service (Interface + Implementation)
* Repository (Interface + Implementation)
* Migration

### ⚙️ CLI Support (Power Users)

* Artisan command with flags
* Dry-run mode (preview only)
* Force overwrite existing files
* Perfect for automation & CI pipelines

---

## 📦 Installation

```bash
composer require mehedi250/laravel-structure-kit
```

Laravel auto-discovers the service provider.

---

## 🖥️ UI-Based Generator

### 🔗 Access URL

```
http://your-app-url/structure-kit
```

Example:

```
http://localhost:8000/structure-kit
```

---

## 🧭 UI Workflow

![Laravel Structure Kit UI](https://raw.githubusercontent.com/mehedi250/laravel-structure-kit/main/src/ui.png)

### How it works:

1. Enter **Model / Module name**
2. Select components to generate
3. Customize folder paths per component
4. See **live file tree preview**
5. Click **Generate**

✅ Namespaces are inferred automatically
✅ Only newly generated files are shown

---

## 🧠 Architecture Benefits

* Encourages separation of concerns
* Service & repository driven design
* Cleaner controllers
* Easier testing & refactoring
* Ideal for large Laravel projects

---

## ⚙️ CLI Command

```bash
php artisan structure-kit
    {name : Model or module name}
    {flags? : m c s r t}
    {--model : Generate model}
    {--controller : Generate controller}
    {--service : Generate service (interface + class)}
    {--repository : Generate repository (interface + class)}
    {--migration : Generate migration}
    {--dry-run : Preview without creating files}
    {--force : Overwrite existing files}
```

---

## 🚀 CLI Examples

Generate everything:

```bash
php artisan structure-kit User mcsrt
```

Generate only service & repository:

```bash
php artisan structure-kit User --service --repository
```

Preview without generating:

```bash
php artisan structure-kit User mcsr --dry-run
```

---

## 🧪 Ideal Use Cases

* New Laravel project setup
* Refactoring legacy code
* Enforcing team architecture rules
* Teaching clean architecture
* Rapid scaffolding with confidence

---

## 🤝 Contributing

Contributions are welcome!

GitHub:
[https://github.com/mehedi250/laravel-structure-kit](https://github.com/mehedi250/laravel-structure-kit)

---

## 📜 License

MIT License
© Md. Mehedi Hasan Shawon
