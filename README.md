# Laravel Structure Kit

Laravel Structure Kit is a **UI + CLI based architecture generator** for Laravel projects.  
It helps you generate **clean, scalable project structures** using **custom paths**, **live preview**, and **flexible flags**.

---

## ✨ Features

- ✅ UI-based architecture generator
- ✅ Custom path editor (fully configurable)
- ✅ Live preview of generated file tree
- ✅ Service & Repository with interfaces
- ✅ Auto namespace generation from paths
- ✅ CLI support with flags & options
- ✅ Dry-run & force overwrite support
- ✅ Shows **only newly generated files**

---

## 📦 Installation

```bash
composer require mehedi250/laravel-structure-kit
```

---

## 🖥️ UI Based Architecture Generator

### 🔗 UI Access Link

```
http://your-app-url/structure-kit
```

Example:
```
http://localhost:8000/structure-kit
```

---

## 🧭 UI Usage

<img width="987" height="1323" alt="0 0 0 0_8000_structure-kit (1)" src="https://github.com/user-attachments/assets/a428385b-a3db-4a5d-b40b-3ed6ae552eaa" />

1. Enter model/module name  
2. Select components (Model, Controller, Service, Repository, Migration)  
3. Customize paths for each component  
4. Preview generated file tree live  
5. Click **Generate**

Namespaces are auto-generated from paths.


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

## 🚀 Examples

```bash
php artisan structure-kit User mcsrt
php artisan structure-kit User --service --repository
php artisan structure-kit User mcsr --dry-run
```

---

## 📜 License

MIT
