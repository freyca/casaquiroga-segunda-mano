<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ComponentIssues;

use App\Filament\Admin\Resources\ComponentIssues\Pages\CreateComponentIssue;
use App\Filament\Admin\Resources\ComponentIssues\Pages\EditComponentIssue;
use App\Filament\Admin\Resources\ComponentIssues\Pages\ListComponentIssues;
use App\Filament\Admin\Resources\ComponentIssues\Pages\ViewComponentIssue;
use App\Filament\Admin\Resources\ComponentIssues\Schemas\ComponentIssueForm;
use App\Filament\Admin\Resources\ComponentIssues\Schemas\ComponentIssueInfolist;
use App\Filament\Admin\Resources\ComponentIssues\Tables\ComponentIssuesTable;
use App\Models\ComponentIssue;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Str;

final class ComponentIssueResource extends Resource
{
    protected static ?string $model = ComponentIssue::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Wrench;

    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): string
    {
        return Str::ucfirst(__('issues.issues_management'));
    }

    public static function getNavigationLabel(): string
    {
        return Str::ucfirst(__('issues.component_issue'));
    }

    public static function getLabel(): string
    {
        return Str::ucfirst(__('issues.component_issue'));
    }

    public static function getPluralLabel(): string
    {
        return Str::ucfirst(__('issues.component_issues'));
    }

    public static function form(Schema $schema): Schema
    {
        return ComponentIssueForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ComponentIssueInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ComponentIssuesTable::configure($table);
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
            'index' => ListComponentIssues::route('/'),
            'create' => CreateComponentIssue::route('/create'),
            'view' => ViewComponentIssue::route('/{record}'),
            'edit' => EditComponentIssue::route('/{record}/edit'),
        ];
    }
}
