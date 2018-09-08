<?php

namespace Jenbuzz\LaravelUuid\Traits;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Jenbuzz\LaravelUuid\Exceptions\UuidColumnNotFoundException;
use Ramsey\Uuid\Uuid as RamseyUuid;
use InvalidArgumentException;

trait Uuid
{
    private $validUuidVersions = [1, 3, 4, 5];

    public static function bootUuid()
    {
        static::creating(function (Model $model) {
            if ((new static)->hasColumnUuid($model)) {
                $model->setUuid((new static)->generateUuid());
            }
        });

        static::saving(function (Model $model) {
            if ((new static)->hasColumnUuid($model) && $model->getGenerateOnSave() && !$model->getUuid()) {
                $model->setUuid((new static)->generateUuid());
            }
        });
    }

    private function hasColumnUuid(Model $model): bool
    {
        if (!Schema::hasColumn($model->getTable(), $model->getUuidColumnName())) {
            throw new UuidColumnNotFoundException(
                sprintf('Column %s not found in table %s', $model->getUuidColumnName(), $model->getTable())
            );
        }

        return true;
    }

    public function generateUuid(): string
    {
        switch ($this->getUuidVersion()) {
            case 1:
                return RamseyUuid::uuid1()->toString();
            case 3:
                return RamseyUuid::uuid3(RamseyUuid::NAMESPACE_DNS, $this->getUuidString())->toString();
            case 4:
                return RamseyUuid::uuid4()->toString();
            case 5:
                return RamseyUuid::uuid5(RamseyUuid::NAMESPACE_DNS, $this->getUuidString())->toString();
            default:
                throw new InvalidArgumentException;
        }
    }

    public function getUuid(): string
    {
        return $this->{$this->getUuidColumnName()};
    }

    public function setUuid(string $uuid)
    {
        $this->{$this->getUuidColumnName()} = $uuid;
    }

    public function getUuidColumnName(): string
    {
        return !empty($this->uuidColumnName) ? $this->uuidColumnName : 'uuid';
    }

    public function getUuidVersion(): string
    {
        return !empty($this->uuidVersion) && in_array($this->uuidVersion, $this->validUuidVersions) ?
            $this->uuidVersion : 4;
    }

    public function getUuidString(): string
    {
        return !empty($this->uuidString) ? $this->uuidString : '';
    }

    public function getGenerateOnSave(): bool
    {
        return !empty($this->uuidGenerateOnSave) ? $this->uuidGenerateOnSave : false;
    }

    public static function findByUuid(string $uuid): ?Model
    {
        if (!RamseyUuid::isValid($uuid)) {
            return null;
        }

        return (new static)->newQuery()->where((new static)->getUuidColumnName(), '=', $uuid)->first();
    }
}
