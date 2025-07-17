<?php

namespace App\Filament\Resources\DepatmentResource\RelationManagers;

use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'categories';

    public function form(Form $form): Form
    {
        $department = $this->getOwnerRecord();

        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('parent_id')
                    ->label('Parent Category')
                    ->relationship(
                        name: 'parent',
                        titleAttribute: 'name',
                        modifyQueryUsing: function (Builder $query, $livewire) use ($department) {

                            $currentCategory = $livewire->getMountedTableActionRecord();

                            $query->where('department_id', $department->id);

                            if ($currentCategory && $currentCategory->id) {
                                $query->where('id', '!=', $currentCategory->id)->where('parent_id', '!=', $currentCategory->id);
                            }

                            return $query;
                        }
                    )
                    ->nullable()
                    ->preload()
                    ->searchable()
                ,
                Checkbox::make('active')->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('parent.name')->sortable()->searchable(),
                Tables\Columns\IconColumn::make('active')->boolean(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
