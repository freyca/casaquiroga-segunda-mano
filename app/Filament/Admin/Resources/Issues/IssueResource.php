<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Issues;

use App\Filament\Admin\Resources\Issues\Pages\CreateIssue;
use App\Filament\Admin\Resources\Issues\Pages\EditIssue;
use App\Filament\Admin\Resources\Issues\Pages\ListIssues;
use App\Filament\Admin\Resources\Issues\Pages\ViewIssue;
use App\Filament\Admin\Resources\Issues\Schemas\IssueForm;
use App\Filament\Admin\Resources\Issues\Schemas\IssueInfolist;
use App\Filament\Admin\Resources\Issues\Tables\IssuesTable;
use App\Models\Issue;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Str;

final class IssueResource extends Resource
{
    protected static ?string $model = Issue::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Wrench;

    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): string
    {
        return Str::ucfirst(__('issues_management'));
    }

    public static function getNavigationLabel(): string
    {
        return Str::ucfirst(__('issue'));
    }

    public static function getLabel(): string
    {
        return Str::ucfirst(__('issue'));
    }

    public static function getPluralLabel(): string
    {
        return Str::ucfirst(__('issues'));
    }

    public static function form(Schema $schema): Schema
    {
        return IssueForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return IssueInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IssuesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIssues::route('/'),
            'create' => CreateIssue::route('/create'),
            'view' => ViewIssue::route('/{record}'),
            'edit' => EditIssue::route('/{record}/edit'),
        ];
    }
}
