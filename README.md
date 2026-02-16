# Laravel Structure Kit

Laravel Structure Kit is a **UI + CLI based architecture generator** for Laravel projects.  
It helps you generate **clean, scalable project structures** using **custom paths**, **live preview**, and **flexible flags**.

---

## ✨ Features

- UI-based architecture generator
- Custom path editor
- Live preview of generated file tree
- Service & Repository with interfaces
- CLI support with flags & options
- Dry-run & force overwrite support

---

## 📦 Installation

```bash
composer require mehedi/laravel-structure-kit
```

---

## ⚙️ CLI Command

```php
protected $signature = 'structure-kit
    {name : Model or module name}
    {flags? : m c s r t}
    {--model : Generate model}
    {--controller : Generate controller}
    {--service : Generate service (interface + class)}
    {--repository : Generate repository (interface + class)}
    {--migration : Generate migration}
    {--dry-run : Preview without creating files}
    {--force : Overwrite existing files}';

protected $description = 'Generate Laravel structure using flags or options (m c s r t)';
```

---

## 🚀 Usage Examples

```bash
php artisan structure-kit User mcsrt
php artisan structure-kit User --service --repository
php artisan structure-kit User mcsr --dry-run
```

---

## 🌳 Generated Tree Preview

Only newly generated files are shown:

```
app/Services/UserService.php
app/Services/Contracts/UserServiceInterface.php
app/Repositories/UserRepository.php
app/Repositories/Contracts/UserRepositoryInterface.php
```

---

## 📜 License

MIT License