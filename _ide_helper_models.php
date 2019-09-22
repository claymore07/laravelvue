<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Author
 *
 * @property int $id
 * @property string $name نام نویسنده
 * @property string $authorableType
 * @property int $authorableId
 * @property string|null $affiliation
 * @property int $corresponding
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $authorable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author whereAffiliation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author whereAuthorableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author whereAuthorableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author whereCorresponding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author whereUpdatedAt($value)
 */
	class Author extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BlackList
 *
 * @property int $id
 * @property string $title عنوان مجله
 * @property string $issn
 * @property string $indexing
 * @property string $url
 * @property string $fakeUrl
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlackList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlackList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlackList query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlackList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlackList whereFakeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlackList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlackList whereIndexing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlackList whereIssn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlackList whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlackList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlackList whereUrl($value)
 */
	class BlackList extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Book
 *
 * @property int $id
 * @property int $booktypeId کلید خارجی نوع کتاب
 * @property int $profileId کلید پروفایل
 * @property int $excerptId کلید نوع مستخرج بودن
 * @property int|null $status وضعیت بررسی
 * @property string $title عنوان کتاب
 * @property string $isbn شابک
 * @property string $subject موضوع
 * @property string $publisher مشخصات انتشارات
 * @property string $edited ویرایش شده یا نه
 * @property int|null $editedNumber شماره ویرایش
 * @property int $publishNumber شماره چاپ
 * @property string $publishYear سال چاپ
 * @property int $copyNumber تیراژ کتاب
 * @property int $pages تعداد صفحات
 * @property int|null $nationalCode شماره کتابخانه ملی
 * @property string|null $congressCode رده بندی کنگره
 * @property string|null $deweyCode رده بندی دیویی
 * @property float $score امتیاز کسب شده
 * @property int $termId ترم ثبت شده
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Models\Author $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Author[] $authors
 * @property-read \App\Models\BookType $booktype
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Checklist[] $checklists
 * @property-read \App\Models\Excerpt $excerpt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Files[] $files
 * @property-read \App\Models\Profile $profile
 * @property-read \App\Models\Term $term
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereBooktypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereCongressCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereCopyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereDeweyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereEdited($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereEditedNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereExcerptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereNationalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book wherePages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book wherePublishNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book wherePublishYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book wherePublisher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereTermId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereUpdatedAt($value)
 */
	class Book extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Booklet
 *
 * @property int $id
 * @property int $profileId کلید پروفایل
 * @property int $degreeId کلید خارجی مقطع
 * @property int $scoreId کلید  جدول امتیاز
 * @property int|null $status وضعیت بررسی
 * @property string $title عنوان جزوه یا اسلاید
 * @property string $name نام درس
 * @property string $bookletType نوع جزوه
 * @property string|null $compilationDate تاریخ تالیف
 * @property float $score امتیاز کسب شده
 * @property int $termId ترم ثبت شده
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Checklist[] $checklists
 * @property-read \App\Models\Degree $degree
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Files[] $files
 * @property-read \App\Models\Profile $profile
 * @property-read \App\Models\Score $scores
 * @property-read \App\Models\Term $term
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booklet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booklet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booklet query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booklet whereBookletType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booklet whereCompilationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booklet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booklet whereDegreeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booklet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booklet whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booklet whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booklet whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booklet whereScoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booklet whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booklet whereTermId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booklet whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booklet whereUpdatedAt($value)
 */
	class Booklet extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BookType
 *
 * @property int $id
 * @property string $name نوع کتاب
 * @property float $maxscore حداکثر امتیاز
 * @property float $minscore حداقل امتیاز
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookType whereMaxscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookType whereMinscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookType whereUpdatedAt($value)
 */
	class BookType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Checklist
 *
 * @property int $id
 * @property string|null $list
 * @property string|null $comment
 * @property string $checkableType
 * @property int $checkableId
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $checkable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Checklist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Checklist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Checklist query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Checklist whereCheckableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Checklist whereCheckableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Checklist whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Checklist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Checklist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Checklist whereList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Checklist whereUpdatedAt($value)
 */
	class Checklist extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Conference
 *
 * @property int $id
 * @property int $conftypeId شناسه نوع کنفرانس
 * @property string $name نام کنفرانس
 * @property string $presentationType نوع ارائه
 * @property string $organizer برگزار کننده کنفرانس
 * @property string $city شهر برگزاری
 * @property int $period دوره برگزاری
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Models\ConfType $conftype
 * @property-read \App\Models\Paper $paper
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Paper[] $papers
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conference newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conference newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conference query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conference whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conference whereConftypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conference whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conference whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conference whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conference whereOrganizer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conference wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conference wherePresentationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conference whereUpdatedAt($value)
 */
	class Conference extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ConfType
 *
 * @property int $id
 * @property string $name نوع کنفر انس
 * @property float $maxscore حداکثر امتیاز
 * @property float $minscore حداقل امتیاز
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Conference[] $conferences
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfType whereMaxscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfType whereMinscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfType whereUpdatedAt($value)
 */
	class ConfType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Course
 *
 * @property int $id
 * @property int $profileId کلید خارجی پروفایل
 * @property int $scoreId کلید  جدول امتیاز
 * @property int|null $status وضعیت بررسی
 * @property string $title عنوان دوره
 * @property string $role نقش در دوره مدرس یا شرکت کننده
 * @property string $organization نام موسسه یا سازمان برگزار کننده
 * @property string $holdingDate تاریخ برگزاری
 * @property int $duration مدت زمان دوره
 * @property float $score امتیاز کسب شده
 * @property int $termId ترم ثبت شده
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Checklist[] $checklists
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Files[] $files
 * @property-read \App\Models\Profile $profile
 * @property-read \App\Models\Score $scores
 * @property-read \App\Models\Term $term
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereHoldingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereOrganization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereScoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereTermId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereUpdatedAt($value)
 */
	class Course extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Degree
 *
 * @property int $id
 * @property string $name مدرک
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Profile[] $profiles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Thesis[] $theses
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Degree newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Degree newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Degree query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Degree whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Degree whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Degree whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Degree whereUpdatedAt($value)
 */
	class Degree extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Department
 *
 * @property int $id
 * @property string $name نام گروه
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Profile[] $profiles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereUpdatedAt($value)
 */
	class Department extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Excerpt
 *
 * @property int $id
 * @property string $name مستخرج از
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Paper[] $papers
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excerpt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excerpt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excerpt query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excerpt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excerpt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excerpt whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excerpt whereUpdatedAt($value)
 */
	class Excerpt extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Faculty
 *
 * @property int $id
 * @property string $name نام دانشکده
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Profile[] $profiles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faculty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faculty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faculty query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faculty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faculty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faculty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faculty whereUpdatedAt($value)
 */
	class Faculty extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Files
 *
 * @property int $id
 * @property string $name
 * @property string $fileableType
 * @property int $fileableId
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $fileable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Files newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Files newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Files query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Files whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Files whereFileableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Files whereFileableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Files whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Files whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Files whereUpdatedAt($value)
 */
	class Files extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Grant
 *
 * @property int $id
 * @property int $profileId کلید پروفایل
 * @property int $scoreId کلید خارجی امتیاز
 * @property int|null $status وضعیت بررسی
 * @property string $title عنوان گرنت جذب شده
 * @property string $type نوع گرنت جذب شده
 * @property int $budget میزان گرنت جذب شده
 * @property string|null $submitDate تاریخ جذب
 * @property float $score امتیاز کسب شده
 * @property int $termId ترم ثبت شده
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Checklist[] $checklists
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Files[] $files
 * @property-read \App\Models\Profile $profile
 * @property-read \App\Models\Score $scores
 * @property-read \App\Models\Term $term
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grant query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grant whereBudget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grant whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grant whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grant whereScoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grant whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grant whereSubmitDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grant whereTermId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grant whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grant whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grant whereUpdatedAt($value)
 */
	class Grant extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Invention
 *
 * @property int $id
 * @property int $profileId کلید پروفایل
 * @property int $inventionTypesId کلید خارجی نوع اختراع
 * @property int|null $status وضعیت بررسی
 * @property string $title عنوان دانش فنی/ اختراع
 * @property string $post سمت در کار
 * @property string $authorities نام مرجع تایید کننده
 * @property string|null $affiliation نام موسسه وابسته
 * @property string|null $license آیا پتنت فروش یا لایسنس دارد
 * @property string|null $licenseNumber شماره ثبت پتنت
 * @property string|null $registrationNumber شماره ثبت شرکت
 * @property string|null $companyName نام شرکت
 * @property string|null $companyType نوع شرکت دانش بنیان یا دانشگاهی
 * @property string|null $companyAddress آدرس شرکت
 * @property string|null $submitDate تاریخ ثبت یا تایید
 * @property float $score امتیاز کسب شده
 * @property int $termId ترم ثبت شده
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Checklist[] $checklists
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Files[] $files
 * @property-read \App\Models\InventionType $inventionType
 * @property-read \App\Models\Profile $profile
 * @property-read \App\Models\Term $term
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention whereAffiliation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention whereAuthorities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention whereCompanyAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention whereCompanyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention whereInventionTypesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention whereLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention whereLicenseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention wherePost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention whereSubmitDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention whereTermId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invention whereUpdatedAt($value)
 */
	class Invention extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\InventionType
 *
 * @property int $id
 * @property string $name نوع داوری
 * @property float $maxscore حداکثر امتیاز
 * @property float $minscore حداقل امتیاز
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Invention[] $inventions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InventionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InventionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InventionType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InventionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InventionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InventionType whereMaxscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InventionType whereMinscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InventionType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InventionType whereUpdatedAt($value)
 */
	class InventionType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Journal
 *
 * @property int $id
 * @property int $jtypeId شماره نوع ژونال
 * @property string|null $name نام ژونال
 * @property string|null $publisher
 * @property int|null $blacklistId کلید  جدول بلک لیست
 * @property string|null $volume شماره مجلد
 * @property string|null $issue شماره مجله
 * @property string|null $pages شماره صفحات
 * @property string|null $issn شماره ISSN
 * @property string|null $pissn
 * @property float|null $IFactor
 * @property float|null $FIF
 * @property string|null $scopus انیدکس اسکپوس
 * @property string|null $JCR
 * @property float|null $JRK
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Models\Jtype $jtype
 * @property-read \App\Models\Paper $paper
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Paper[] $papers
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal whereBlacklistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal whereFIF($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal whereIFactor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal whereIssn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal whereIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal whereJCR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal whereJRK($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal whereJtypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal wherePages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal wherePissn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal wherePublisher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal whereScopus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Journal whereVolume($value)
 */
	class Journal extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Jtype
 *
 * @property int $id
 * @property string $name نوع ژونال
 * @property float $maxscore حداکثر امتیاز
 * @property float $minscore حداقل امتیاز
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Journal[] $journals
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Jtype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Jtype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Jtype query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Jtype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Jtype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Jtype whereMaxscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Jtype whereMinscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Jtype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Jtype whereUpdatedAt($value)
 */
	class Jtype extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Member
 *
 * @property int $id
 * @property string $name عضویت در باشگاه
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Profile[] $profiles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereUpdatedAt($value)
 */
	class Member extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Paper
 *
 * @property int $id
 * @property int $profileId شناسه صاحب مقاله
 * @property string $paperableType
 * @property int $paperableId
 * @property int $lang زبان مقاله
 * @property string $title عنوان مقاله
 * @property string $abstract چکیده مقاله
 * @property string|null $doi
 * @property string|null $link لینک سایت مقاله
 * @property int|null $status وضعیت بررسی
 * @property int $reward
 * @property float $score امتیاز کسب شده
 * @property int $termId ترم ثبت شده
 * @property int $excerptId نوع استخراج مقاله
 * @property string|null $license شماره مجاوز
 * @property string|null $licenseTo نوع مجوز
 * @property int $authorCount تعداد نویسندگان
 * @property string $isresponsible  نویسنده مسئول هست یا نه
 * @property int $authorPlace جایگاه نویسنده
 * @property string|null $acceptDate تاریخ پذیرش
 * @property string $publishDate
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Models\Author $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Author[] $authors
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Checklist[] $checklists
 * @property-read \App\Models\Excerpt $excerpt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Files[] $files
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $paperable
 * @property-read \App\Models\Profile $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read \App\Models\Term $term
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereAbstract($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereAcceptDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereAuthorCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereAuthorPlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereDoi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereExcerptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereIsresponsible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereLicenseTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper wherePaperableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper wherePaperableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereTermId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Paper whereUpdatedAt($value)
 */
	class Paper extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Position
 *
 * @property int $id
 * @property string $name نوع همکاری
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Profile[] $profiles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Position newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Position newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Position query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Position whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Position whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Position whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Position whereUpdatedAt($value)
 */
	class Position extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Profile
 *
 * @property int $id
 * @property int $userId
 * @property string $Fname نام کوچک
 * @property string $Lname نام خانوادگی
 * @property int|null $base پایه
 * @property int $degreeId مدرک تحصیلی
 * @property int $rankId
 * @property int $positionId نوع همکاری
 * @property int $facultyId نام دانشکده
 * @property int $departmentId نام گروه
 * @property int $memberId نوع عضویت
 * @property string $phone شماره تماس
 * @property string $siba شماره حساب
 * @property string $personalId شماره دانشجویی یا شماره استادی
 * @property string|null $deletedAt
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProposalReview[] $ProposalReviews
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Booklet[] $booklets
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Course[] $courses
 * @property-read \App\Models\Degree $degree
 * @property-read \App\Models\Department $department
 * @property-read \App\Models\Faculty $faculty
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Grant[] $grants
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Invention[] $inventions
 * @property-read \App\Models\Member $member
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Paper[] $papers
 * @property-read \App\Models\Position $position
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @property-read \App\Models\Rank $rank
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Referee[] $referees
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ResearchActivity[] $researchActivity
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ResearchProposal[] $researchProposals
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reward[] $rewards
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TEDChair[] $tedChairs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Thesis[] $theses
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereDegreeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereFacultyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereFname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereLname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile wherePersonalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereRankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereSiba($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereUserId($value)
 */
	class Profile extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Project
 *
 * @property int $id
 * @property int $profileId کلید خارجی پروفایل
 * @property int $projectTypesId کلید خارجی نوع طرح
 * @property int|null $status وضعیت بررسی
 * @property string $title عنوان طرح
 * @property string $organization نام سازمان طرف قرارداد
 * @property int $budget بودجه طرح
 * @property string $councilAprovedate تاریخ تصویب شورای پژوهش
 * @property string $defenseDate تاریخ دفاع
 * @property float $score امتیاز کسب شده
 * @property int $termId ترم ثبت شده
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Models\Author $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Author[] $authors
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Checklist[] $checklists
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Files[] $files
 * @property-read \App\Models\Profile $profile
 * @property-read \App\Models\ProjectType $projectType
 * @property-read \App\Models\Term $term
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereBudget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereCouncilAprovedate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereDefenseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereOrganization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereProjectTypesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereTermId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereUpdatedAt($value)
 */
	class Project extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProjectType
 *
 * @property int $id
 * @property string $name نوع طرح
 * @property float $maxscore حداکثر امتیاز
 * @property float $minscore حداقل امتیاز
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectType whereMaxscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectType whereMinscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectType whereUpdatedAt($value)
 */
	class ProjectType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProposalReview
 *
 * @property int $id
 * @property int $researchProposalId شماره شناسه پروپزال طرح
 * @property int $profileId شماره شناسه کاربری داور
 * @property int|null $status وضعیت بررسی
 * @property string $comment نظر داور
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Models\Profile $profile
 * @property-read \App\Models\ResearchProposal $proposal
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalReview query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalReview whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalReview whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalReview whereResearchProposalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalReview whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalReview whereUpdatedAt($value)
 */
	class ProposalReview extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProposalType
 *
 * @property int $id
 * @property string $name عنوان نوع طرح
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ResearchProposal[] $proposals
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalType whereUpdatedAt($value)
 */
	class ProposalType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProposalUsage
 *
 * @property int $id
 * @property string $name عنوان کاربردی طرح
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ResearchProposal[] $proposals
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalUsage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalUsage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalUsage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalUsage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalUsage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalUsage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProposalUsage whereUpdatedAt($value)
 */
	class ProposalUsage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Rank
 *
 * @property int $id
 * @property string $name رتبه علمی
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Profile[] $profiles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rank query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rank whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rank whereUpdatedAt($value)
 */
	class Rank extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Referee
 *
 * @property int $id
 * @property int $profileId کلید خارجی پروفایل
 * @property int $refereeTypesId کلید خارجی نوع داوری
 * @property int|null $status وضعیت بررسی
 * @property string $title عنوان اثر
 * @property string|null $journalName نام ژورنال
 * @property string|null $journalIssn issn ژورنال
 * @property string|null $refereeDate تاریخ داوری
 * @property float $score امتیاز کسب شده
 * @property int $termId ترم ثبت شده
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Checklist[] $checklists
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Files[] $files
 * @property-read \App\Models\Profile $profile
 * @property-read \App\Models\RefereeType $refereeType
 * @property-read \App\Models\Term $term
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referee query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referee whereJournalIssn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referee whereJournalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referee whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referee whereRefereeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referee whereRefereeTypesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referee whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referee whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referee whereTermId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referee whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referee whereUpdatedAt($value)
 */
	class Referee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RefereeType
 *
 * @property int $id
 * @property string $name نوع داوری
 * @property float $maxscore حداکثر امتیاز
 * @property float $minscore حداقل امتیاز
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Referee[] $referees
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefereeType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefereeType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefereeType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefereeType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefereeType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefereeType whereMaxscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefereeType whereMinscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefereeType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefereeType whereUpdatedAt($value)
 */
	class RefereeType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Regulation
 *
 * @property int $id
 * @property string $detail
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Regulation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Regulation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Regulation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Regulation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Regulation whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Regulation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Regulation whereUpdatedAt($value)
 */
	class Regulation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ResearchActivity
 *
 * @property int $id
 * @property int $profileId کلید پروفایل
 * @property int $researchActivityTypesId کلید خارجی نوع مسئولیت
 * @property int|null $status وضعیت بررسی
 * @property string $title عنوان سمت یا مسئولیت
 * @property string $authorities نام مرجع تایید کننده
 * @property string|null $startDate تاریخ شروع فعالیت
 * @property string|null $endDate تاریخ اتمام فعالیت
 * @property float $score امتیاز کسب شده
 * @property int $termId ترم ثبت شده
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Models\ResearchActivityType $ResearchActivityType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Checklist[] $checklists
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Files[] $files
 * @property-read \App\Models\Profile $profile
 * @property-read \App\Models\Term $term
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivity whereAuthorities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivity whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivity whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivity whereResearchActivityTypesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivity whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivity whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivity whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivity whereTermId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivity whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivity whereUpdatedAt($value)
 */
	class ResearchActivity extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ResearchActivityType
 *
 * @property int $id
 * @property string $name نوع فعالیت پژوهشی
 * @property float $maxscore حداکثر امتیاز
 * @property float $minscore حداقل امتیاز
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ResearchActivity[] $researchActivities
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivityType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivityType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivityType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivityType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivityType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivityType whereMaxscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivityType whereMinscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivityType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchActivityType whereUpdatedAt($value)
 */
	class ResearchActivityType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ResearchProposal
 *
 * @property int $id
 * @property int $profileId شماره شناسه کاربری
 * @property int $proposalTypeId شماره شناسه نوع طرح
 * @property int $proposalUsageId شماره شناسه نوع کاربرد طرح
 * @property int $facultyId شماره شناسه دانشکده مربوطه
 * @property string $title عنوان فارسی
 * @property string $enTitle عنوان انگلیسی
 * @property string $abstract چکیده
 * @property string $introduction مقدمه
 * @property string $problem بیان مسئله
 * @property string $innovation جنبه نوآوری
 * @property string $requirements نیازمندی ها
 * @property int|null $status وضعیت بررسی
 * @property int $value ارزش مالی طرح
 * @property int $budget بودجه طرح
 * @property string $duration پیش بینی مدت اجرا
 * @property string $projectLocation محل اجرای طرح
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Models\Author $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Author[] $authors
 * @property-read \App\Models\Faculty $faculty
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Files[] $files
 * @property-read \App\Models\Profile $profile
 * @property-read \App\Models\ProposalType $proposalType
 * @property-read \App\Models\ProposalUsage $proposalUsage
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProposalReview[] $reviews
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal whereAbstract($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal whereBudget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal whereEnTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal whereFacultyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal whereInnovation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal whereIntroduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal whereProblem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal whereProjectLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal whereProposalTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal whereProposalUsageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal whereRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResearchProposal whereValue($value)
 */
	class ResearchProposal extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Reward
 *
 * @property int $id
 * @property int $profileId کلید خارجی پروفایل
 * @property int $scoreId کلید  جدول امتیاز
 * @property int|null $status وضعیت بررسی
 * @property string $name نام جشنواره
 * @property string $type نوع جشنواره
 * @property string $title عنوان جایزه
 * @property int $place رتبه کسب شده
 * @property int|null $period دوره برگزاری
 * @property string $holdingDate تاریخ برگزاری
 * @property float $score امتیاز کسب شده
 * @property int $termId ترم ثبت شده
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Checklist[] $checklists
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Files[] $files
 * @property-read \App\Models\Profile $profile
 * @property-read \App\Models\Score $scores
 * @property-read \App\Models\Term $term
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward whereHoldingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward whereScoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward whereTermId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward whereUpdatedAt($value)
 */
	class Reward extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name نوع نقش
 * @property string $faName
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereFaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Score
 *
 * @property int $id
 * @property string $name نام بخش روزمه
 * @property float $maxscore حداکثر امتیاز
 * @property float $minscore حداقل امتیاز
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Score newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Score newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Score query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Score whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Score whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Score whereMaxscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Score whereMinscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Score whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Score whereUpdatedAt($value)
 */
	class Score extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tag
 *
 * @property int $id
 * @property string $name
 * @property string $taggableType
 * @property int $taggableId
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $taggable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereTaggableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereTaggableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereUpdatedAt($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TEDChair
 *
 * @property int $id
 * @property int $profileId کلید خارجی پروفایل
 * @property int $tedTypesId نوع کرسی
 * @property int|null $status وضعیت بررسی
 * @property string $title عنوان کرسی
 * @property string $location محل برگزاری کرسی
 * @property string|null $councilAprovedate تاریخ صدور مجوز شورای پژوهش
 * @property string $presentationDate تاریخ ارائه کرسی
 * @property float $score امتیاز کسب شده
 * @property int $termId ترم ثبت شده
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Models\TEDType $TEDType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Checklist[] $checklists
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Files[] $files
 * @property-read \App\Models\Profile $profile
 * @property-read \App\Models\Term $term
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDChair newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDChair newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDChair query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDChair whereCouncilAprovedate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDChair whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDChair whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDChair whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDChair wherePresentationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDChair whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDChair whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDChair whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDChair whereTedTypesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDChair whereTermId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDChair whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDChair whereUpdatedAt($value)
 */
	class TEDChair extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TEDType
 *
 * @property int $id
 * @property string $name نوع طرح
 * @property float $maxscore حداکثر امتیاز
 * @property float $minscore حداقل امتیاز
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TEDChair[] $TEDChairs
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDType whereMaxscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDType whereMinscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TEDType whereUpdatedAt($value)
 */
	class TEDType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Term
 *
 * @property int $id
 * @property string $name نام ترم
 * @property int $status وضعیت ترم فعال یا خیر
 * @property \Illuminate\Support\Carbon $startsAt تاریخ شروع
 * @property \Illuminate\Support\Carbon $endsAt تاریخ اتمام
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Booklet[] $booklets
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Course[] $courses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Invention[] $inventions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Paper[] $papers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Referee[] $referees
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reward[] $rewards
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TEDChair[] $tedChairs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Thesis[] $theses
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Term newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Term newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Term query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Term whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Term whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Term whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Term whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Term whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Term whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Term whereUpdatedAt($value)
 */
	class Term extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ThesesType
 *
 * @property int $id
 * @property string $name نوع داوری
 * @property float $maxscore حداکثر امتیاز
 * @property float $minscore حداقل امتیاز
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Thesis[] $theses
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThesesType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThesesType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThesesType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThesesType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThesesType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThesesType whereMaxscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThesesType whereMinscore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThesesType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThesesType whereUpdatedAt($value)
 */
	class ThesesType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Thesis
 *
 * @property int $id
 * @property int $profileId کلید پروفایل
 * @property int $thesesTypesId کلید خارجی نوع پایان نامه
 * @property int|null $status وضعیت بررسی
 * @property string $title عنوان پایان نامه
 * @property string $groupAprovedate تاریخ تصویت گروه
 * @property string $councilAprovedate تاریخ تصویت گروه
 * @property string|null $codeDate تاریخ تصویت گروه
 * @property string|null $defenseDate تاریخ تصویت گروه
 * @property float $score امتیاز کسب شده
 * @property int $termId ترم ثبت شده
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Checklist[] $checklists
 * @property-read \App\Models\Degree $degree
 * @property-read \App\Models\Profile $profile
 * @property-read \App\Models\Term $term
 * @property-read \App\Models\ThesesType $thesisType
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thesis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thesis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thesis query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thesis whereCodeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thesis whereCouncilAprovedate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thesis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thesis whereDefenseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thesis whereGroupAprovedate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thesis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thesis whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thesis whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thesis whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thesis whereTermId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thesis whereThesesTypesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thesis whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thesis whereUpdatedAt($value)
 */
	class Thesis extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $type
 * @property string|null $bio
 * @property string|null $photo
 * @property int $isActivated
 * @property string|null $ipAddress آدرس ورود کنونی
 * @property \Illuminate\Support\Carbon|null $currentLogin زمان ورود کنونی
 * @property \Illuminate\Support\Carbon|null $lastLogin زمان آخرین ورود
 * @property int $roleId شماره نقش
 * @property string|null $rememberToken
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Paper[] $papers
 * @property-read \App\Models\Profile $profile
 * @property-read \App\Models\Role $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCurrentLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsActivated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

