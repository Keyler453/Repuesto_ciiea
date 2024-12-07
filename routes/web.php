<?php

use App\Http\Controllers\Admin\AdministratorController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\ConvocationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\InvestigationController;
use App\Http\Controllers\Admin\MagazineController;
use App\Http\Controllers\Admin\PublicationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EducationalSoftwareController;
use App\Http\Controllers\Admin\InfographicController;
use App\Http\Controllers\Admin\VinculationDocumentController;
use App\Http\Controllers\BookController as GuestBookController;
use App\Http\Controllers\ContactController as GuestContactController;
use App\Http\Controllers\ConvocationController as GuestConvocationController;
use App\Http\Controllers\EducationalSoftwareController as GuestEducationalSoftwareController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GalleryController as GuestGalleryController;
use App\Http\Controllers\InfographicController as GuestInfographicController;
use App\Http\Controllers\InvestigationController as GuestInvestigationController;
use App\Http\Controllers\MagazineController as GuestMagazineController;
use App\Http\Controllers\ProfesionalPracticeController as GuestProfesionalPracticeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicationController as GuestPublicationController;
use App\Http\Controllers\SocialServiceController as GuestSocialServiceController;
use App\Http\Controllers\VinculationDocumentController as GuestVinculationDocumentController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\PostController;
use App\Models\Resource;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
	return Inertia::render('Home', [
		'canLogin' => Route::has('login'),
		'canRegister' => Route::has('register'),
	]);
})->name('home');

Route::get('/books', [GuestBookController::class, 'index'])->name('guest.books.index');
Route::get('/magazines', [GuestMagazineController::class, 'index'])->name('guest.magazines.index');
Route::get('/hist-publications', [GuestPublicationController::class, 'index'])->name('guest.hist-publications.index');
Route::get('/investigations', [GuestInvestigationController::class, 'index'])->name('guest.investigations.index');

Route::get('/educational-software', [GuestEducationalSoftwareController::class, 'index'])->name('guest.educational-software.index');
Route::get('/educational-software/{slug}', [GuestEducationalSoftwareController::class, 'show'])->name('guest.educational-software.show');

Route::get('/infographics', [GuestInfographicController::class, 'index'])->name('guest.infographics.index');
Route::get('/infographics/{slug}', [GuestInfographicController::class, 'show'])->name('guest.infographics.show');

Route::get('/social-service', [GuestSocialServiceController::class, 'show'])->name('social-service');
Route::get('/profesional-practice', [GuestProfesionalPracticeController::class, 'show'])->name('profesional-practice');
Route::get('/vinculation-documents', [GuestVinculationDocumentController::class, 'index'])->name('vinculation-documents');

Route::get('/convocations', [GuestConvocationController::class, 'index'])->name('guest.convocations.index');
Route::get('/convocations/{slug}', [GuestConvocationController::class, 'show'])->name('guest.convocations.show');

Route::get('/gallery', [GuestGalleryController::class, 'index'])->name('guest.gallery.index');
Route::get('/gallery/{event}', [GuestGalleryController::class, 'show'])->name('guest.gallery.show');

Route::get('/reime', function () {
	return Inertia::render('Reime/Index', [
		'canLogin' => Route::has('login'),
		'canRegister' => Route::has('register'),
	]);
})->name('reime');

Route::get('/contact', [GuestContactController::class, 'index'])->name('guest.contact.index');

Route::get('/public/files/{file}', [FileController::class, 'showPublicFile'])->name('public.file.show');

Route::get('/download/files/{file}', [FileController::class, 'downloadPublicFile'])->name('public.file.download');

Route::get('/profile_images/{image}', [FileController::class, 'showProfileImage'])->name('profile-images.show');




// Rutas GET para mostrar formularios
Route::get('/form/record-reime', [FormController::class, 'show'])->name('form.record-reime');
Route::get('/form-record', [FormController::class, 'show'])->name('form.record');

Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);
Route::put('/posts/{post}', [PostController::class, 'update']);

Route::get('/records', [RecordController::class, 'index'])->name('records.index');
Route::post('/records', [RecordController::class, 'store'])->name('records.store');
Route::get('/records', [RecordController::class, 'index']);

// // Ruta para mostrar todos los registros
// Route::get('/records', [RecordController::class, 'index'])->name('records.index');

// // Ruta para crear un nuevo registro
// Route::get('/records/create', [RecordController::class, 'create'])->name('records.create');

// // Ruta para almacenar un nuevo registro
// Route::post('/records', [RecordController::class, 'store'])->name('records.store');

// // Ruta para mostrar un registro específico
// Route::get('/records/{id}', [RecordController::class, 'show'])->name('records.show');

// // Ruta para editar un registro
// Route::get('/records/{id}/edit', [RecordController::class, 'edit'])->name('records.edit');

// // Ruta para actualizar un registro específico
// Route::put('/records/{id}', [RecordController::class, 'update'])->name('records.update');

// // Ruta para eliminar un registro
// Route::delete('/records/{id}', [RecordController::class, 'destroy'])->name('records.destroy');

Route::get('/dashboard', function () {
	return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:admin'])
	->prefix('admin')
	->group(function () {
		Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

		Route::get('/books', [BookController::class, 'index'])->name('admin.books.index');
		Route::post('/books', [BookController::class, 'store'])->name('admin.books.store');
		Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('admin.books.edit');
		Route::patch('/books', [BookController::class, 'update'])->name('admin.books.update');
		Route::delete('/books', [BookController::class, 'destroy'])->name('admin.books.destroy');
		Route::post('/books/file', [BookController::class, 'uploadFile'])->name('admin.books.upload-file');
		Route::delete('/book/file', [BookController::class, 'deleteFile'])->name('admin.books.delete-file');

		Route::get('/magazines', [MagazineController::class, 'index'])->name('admin.magazines.index');
		Route::post('/magazines', [MagazineController::class, 'store'])->name('admin.magazines.store');
		Route::get('/magazines/{id}/edit', [MagazineController::class, 'edit'])->name('admin.magazines.edit');
		Route::patch('/magazines', [MagazineController::class, 'update'])->name('admin.magazines.update');
		Route::delete('/magazines', [MagazineController::class, 'destroy'])->name('admin.magazines.destroy');
		Route::post('/magazines/file', [MagazineController::class, 'uploadFile'])->name('admin.magazines.upload-file');
		Route::delete('/magazines/file', [MagazineController::class, 'deleteFile'])->name('admin.magazines.delete-file');

		Route::get('/historical-publications', [PublicationController::class, 'index'])->name('admin.historical-publications.index');
		Route::post('/historical-publications', [PublicationController::class, 'store'])->name('admin.historical-publications.store');
		Route::get('/historical-publications/{id}/edit', [PublicationController::class, 'edit'])->name('admin.historical-publications.edit');
		Route::patch('/historical-publications', [PublicationController::class, 'update'])->name('admin.historical-publications.update');
		Route::delete('/historical-publications', [PublicationController::class, 'destroy'])->name('admin.historical-publications.destroy');
		Route::post('/historical-publications/file', [PublicationController::class, 'uploadFile'])->name('admin.historical-publications.upload-file');
		Route::delete('/historical-publications/file', [PublicationController::class, 'deleteFile'])->name('admin.historical-publications.delete-file');

		Route::get('/investigations', [InvestigationController::class, 'index'])->name('admin.investigations.index');
		Route::post('/investigations', [InvestigationController::class, 'store'])->name('admin.investigations.store');
		Route::get('/investigations/{id}/edit', [InvestigationController::class, 'edit'])->name('admin.investigations.edit');
		Route::patch('/investigations', [InvestigationController::class, 'update'])->name('admin.investigations.update');
		Route::delete('/investigations', [InvestigationController::class, 'destroy'])->name('admin.investigations.destroy');
		Route::post('/investigations/file', [InvestigationController::class, 'uploadFile'])->name('admin.investigations.upload-file');
		Route::delete('/investigations/file', [InvestigationController::class, 'deleteFile'])->name('admin.investigations.delete-file');

		Route::get('/convocations', [ConvocationController::class, 'index'])->name('admin.convocations.index');
		Route::post('/convocations', [ConvocationController::class, 'store'])->name('admin.convocations.store');
		Route::get('/convocations/{id}/edit', [ConvocationController::class, 'edit'])->name('admin.convocations.edit');
		Route::patch('/convocations', [ConvocationController::class, 'update'])->name('admin.convocations.update');
		Route::delete('/convocations', [ConvocationController::class, 'destroy'])->name('admin.convocations.destroy');
		Route::post('/convocations/image', [ConvocationController::class, 'uploadImage'])->name('admin.convocations.upload-image');
		Route::delete('/convocations/image', [ConvocationController::class, 'deleteImage'])->name('admin.convocations.delete-image');

		Route::get('/gallery', [GalleryController::class, 'index'])->name('admin.gallery.index');
		Route::post('/gallery', [GalleryController::class, 'store'])->name('admin.gallery.store');
		Route::get('/gallery/{id}/edit', [GalleryController::class, 'edit'])->name('admin.gallery.edit');
		Route::delete('/gallery', [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');
		Route::post('/gallery/images', [GalleryController::class, 'uploadImages'])->name('admin.gallery.upload-images');
		Route::delete('/gallery/images', [GalleryController::class, 'deleteImages'])->name('admin.gallery.delete-images');

		Route::get('/software', [EducationalSoftwareController::class, 'index'])->name('admin.software.index');
		Route::post('/software', [EducationalSoftwareController::class, 'store'])->name('admin.software.store');
		Route::get('/software/{id}/edit', [EducationalSoftwareController::class, 'edit'])->name('admin.software.edit');
		Route::patch('/software', [EducationalSoftwareController::class, 'update'])->name('admin.software.update');
		Route::delete('/software', [EducationalSoftwareController::class, 'destroy'])->name('admin.software.destroy');
		Route::post('/software/image', [EducationalSoftwareController::class, 'uploadImage'])->name('admin.software.upload-image');
		Route::delete('/software/image', [EducationalSoftwareController::class, 'deleteImage'])->name('admin.software.delete-image');
		Route::post('/software/file', [EducationalSoftwareController::class, 'uploadFile'])->name('admin.software.upload-file');
		Route::delete('/software/file', [EducationalSoftwareController::class, 'deleteFile'])->name('admin.software.delete-file');

		Route::get('/infographics', [InfographicController::class, 'index'])->name('admin.infographics.index');
		Route::post('/infographics', [InfographicController::class, 'store'])->name('admin.infographics.store');
		Route::get('/infographics/{id}/edit', [InfographicController::class, 'edit'])->name('admin.infographics.edit');
		Route::patch('/infographics', [InfographicController::class, 'update'])->name('admin.infographics.update');
		Route::delete('/infographics', [InfographicController::class, 'destroy'])->name('admin.infographics.destroy');
		Route::post('/infographics/image', [InfographicController::class, 'uploadImage'])->name('admin.infographics.upload-image');
		Route::delete('/infographics/image', [InfographicController::class, 'deleteImage'])->name('admin.infographics.delete-image');

		Route::get('/vinculation-documents', [VinculationDocumentController::class, 'index'])->name('admin.vinculation-documents.index');
		Route::post('/vinculation-documents', [VinculationDocumentController::class, 'store'])->name('admin.vinculation-documents.store');
		Route::get('/vinculation-documents/{id}/edit', [VinculationDocumentController::class, 'edit'])->name('admin.vinculation-documents.edit');
		Route::patch('/vinculation-documents', [VinculationDocumentController::class, 'update'])->name('admin.vinculation-documents.update');
		Route::delete('/vinculation-documents', [VinculationDocumentController::class, 'destroy'])->name('admin.vinculation-documents.destroy');
		Route::post('/vinculation-documents/file', [VinculationDocumentController::class, 'uploadFile'])->name('admin.vinculation-documents.upload-file');
		Route::delete('/vinculation-documents/file', [VinculationDocumentController::class, 'deleteFile'])->name('admin.vinculation-documents.delete-file');

		Route::get('/administrators', [AdministratorController::class, 'index'])->name('admin.administrators.index');
		Route::post('/administrators', [AdministratorController::class, 'store'])->name('admin.administrators.store');
		Route::get('/administrators/{id}/edit', [AdministratorController::class, 'edit'])->name('admin.administrators.edit');
		Route::patch('/administrators', [AdministratorController::class, 'update'])->name('admin.administrators.update');
		Route::delete('/administrators', [AdministratorController::class, 'destroy'])->name('admin.administrators.destroy');
		Route::post('/administrators/image', [AdministratorController::class, 'uploadImage'])->name('admin.administrators.upload-image');
		Route::delete('/administrators/image', [AdministratorController::class, 'deleteImage'])->name('admin.administrators.delete-image');

		Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
		Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
		Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
		Route::patch('/users', [UserController::class, 'update'])->name('admin.users.update');
		Route::delete('/users', [UserController::class, 'destroy'])->name('admin.users.destroy');
		Route::post('/users/image', [UserController::class, 'uploadImage'])->name('admin.users.upload-image');
		Route::delete('/users/image', [UserController::class, 'deleteImage'])->name('admin.users.delete-image');

		// Route::post('/contact', [ContactController::class, 'update'])->name('admin.contact.update');
	});

require __DIR__ . '/auth.php';
