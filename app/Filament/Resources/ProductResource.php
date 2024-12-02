<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\ProductResource\Pages;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $recordTitleAttribute = 'name';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Product Information')->schema([
                        TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->disabled()
                            ->dehydrated()
                            ->unique(Product::class, 'slug', ignoreRecord: true)
                            ->required(),

                        MarkdownEditor::make('description')
                            ->fileAttachmentsDirectory('products')
                            ->columnSpanFull(),

                    ])->columns(2)
                    ->collapsible(),

                    Section::make('Images')->schema([
                        FileUpload::make('images')->hiddenLabel()
                            ->directory('products')
                            ->panelLayout('grid')
                            ->appendFiles()
                            ->multiple()
                            ->maxFiles(7)
                            ->reorderable()
                    ]),
                ])->columnSpan(2),
                Group::make()->schema([
                    Section::make('Price')->schema([
                        TextInput::make('price')
                            ->numeric()
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->required()
                            ->prefix('EGP')
                            ->minValue(0),
                    ]),

                    Section::make('Associations')->schema([
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->preload()
                            ->searchable()
                            ->required(),

                        Select::make('brand_id')
                            ->relationship('brand', 'name')
                            ->preload()
                            ->searchable()
                            ->required(),
                    ]),
                    Section::make('Status')->schema([
                        Toggle::make('in_stock')
                            ->default(true)
                            ->required(),
                        
                        Toggle::make('is_active')
                                ->default(true)
                                ->required(),

                        Toggle::make('is_featured')
                            ->default(false)
                            ->required(),

                        Toggle::make('on_sale')
                            ->default(false)
                            ->required(),

                    ]),
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                ImageColumn::make('images')
                    ->circular()
                    ->stacked()
                    ->limitedRemainingText()
                    ->limit(3),
                
                Tables\Columns\TextColumn::make('brand.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
                Tables\Columns\IconColumn::make('in_stock')
                    ->boolean(),
                Tables\Columns\IconColumn::make('on_sale')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable(),
                SelectFilter::make('brand')
                    ->relationship('brand', 'name')
                    ->preload()
                    ->searchable(),
            ])
            ->actions([ActionGroup::make([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
