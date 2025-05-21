## TSM Bulk Uploader Documentation
*******************************

## Client Token, Client ID secret, tenant ID
## $tenant = `'68981705-98d9-44f3-a72b-61c7cd3ef4fd';`
## $tokenUrl = `'https://login.microsoftonline.com/' . $tenant . '/oauth2/v2.0/token';`
## $clientId = `'fa2fb323-21d0-4967-abe7-585013608b13';`
## $clientSecret = `'h2b8Q~ztG8BG0EPZxTbJd7L_5VkM65ItwgfFodsD';`
## path:`\app\Http\Controllers\SubmitTSMNoteControler.php Line 188-192`


## Automation Email Address
`tsmxml@globalfoodequipment.com.au via Microsoft graph`

## curl RESTFUL API
`https:$$$//graph.microsoft.com/v1.0/users/automations@dunbraegroup.onmicrosoft.com/sendMail`


# 📄 TSM Notes Submission API

This Laravel controller handles the upload, processing, storage, and logging of **TSM Job Notes** via CSV files. It also integrates with Microsoft Graph API to send these notes as email attachments.`

## 📂 Controller: `SubmitTSMNotesController`

---

## 🚀 Features

- Upload and process CSV files containing TSM job notes.
- Automatically injects metadata (`JOB NUMBER`, `NOTES`, `USER`) and stores files.
- Saves parsed entries to the database (`TSMNote`).
- Sends files as email attachments using Microsoft Graph API.
- Logs all activities in the `ActivityLog` table.

---

## 🏗️ Directory Structure

Uploaded and processed files are stored in:

- `storage/app/tsm-notes-upload/`
- `storage/app/tsm-notes-final/`

---

## 📦 Dependencies

- Laravel 8+
- cURL enabled
- Microsoft Azure App Registration (client ID, secret, tenant ID)
- Tables: `TSMNote`, `ActivityLog`

---

## 🧪 API Endpoints

### 1. `GET /api/tsm-notes`
Returns all submitted TSM notes with user information.

#### Response:
```json
[
  {
    "job_number": "JOB123",
    "submitted_by": "TSM001",
    "name": "John Doe",
    "email": "john.doe@example.com",
    "file_path": "path/to/file.csv",
    "processed_at": "2024-10-01T10:00:00",
    "action": "Upload",
    "status": "Success"
  }
]

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
# TSM-BulkUpload
