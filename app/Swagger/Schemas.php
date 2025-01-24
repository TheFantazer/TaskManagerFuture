<?php

namespace App\Swagger;

/**
* @OA\Schema(
*     schema="Task",
*     type="object",
*     title="Task",
*     description="Модель задачи",
*     @OA\Property(property="id", type="integer", description="ID задачи"),
*     @OA\Property(property="title", type="string", description="Название задачи", maxLength=255),
*     @OA\Property(property="description", type="string", description="Описание задачи", nullable=true),
*     @OA\Property(property="due_date", type="string", format="date-time", description="Срок выполнения"),
*     @OA\Property(property="create_date", type="string", format="date-time", description="Дата создания"),
*     @OA\Property(property="status", type="string", description="Статус задачи", enum={"выполнена", "не выполнена"}),
*     @OA\Property(property="priority", type="string", description="Приоритет задачи", enum={"низкий", "средний", "высокий"}),
*     @OA\Property(property="category", type="string", description="Категория задачи", maxLength=50)
* )
*/

/**
* @OA\Schema(
*     schema="TaskCreateRequest",
*     type="object",
*     title="TaskCreateRequest",
*     required={"title", "due_date", "create_date", "status", "priority", "category"},
*     @OA\Property(property="title", type="string", description="Название задачи", maxLength=255),
*     @OA\Property(property="description", type="string", description="Описание задачи", nullable=true),
*     @OA\Property(property="due_date", type="string", format="date-time", description="Срок выполнения"),
*     @OA\Property(property="create_date", type="string", format="date-time", description="Дата создания"),
*     @OA\Property(property="status", type="string", description="Статус задачи", enum={"выполнена", "не выполнена"}),
*     @OA\Property(property="priority", type="string", description="Приоритет задачи", enum={"низкий", "средний", "высокий"}),
*     @OA\Property(property="category", type="string", description="Категория задачи", maxLength=50)
* )
*/

/**
* @OA\Schema(
*     schema="TaskUpdateRequest",
*     type="object",
*     title="TaskUpdateRequest",
*     @OA\Property(property="title", type="string", description="Название задачи", maxLength=255),
*     @OA\Property(property="description", type="string", description="Описание задачи", nullable=true),
*     @OA\Property(property="due_date", type="string", format="date-time", description="Срок выполнения"),
*     @OA\Property(property="create_date", type="string", format="date-time", description="Дата создания"),
*     @OA\Property(property="status", type="string", description="Статус задачи", enum={"выполнена", "не выполнена"}),
*     @OA\Property(property="priority", type="string", description="Приоритет задачи", enum={"низкий", "средний", "высокий"}),
*     @OA\Property(property="category", type="string", description="Категория задачи", maxLength=50)
* )
*/
