<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ ($machine->brand?->name ?? 'Sin marca') . ' ' . ($machine->model ?? 'Sin modelo') }}</title>

    <style>
        @page {
            size: A4;
            margin: 16mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: #111827;
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.45;
            background: #fff;
        }

        .header,
        .images,
        .specs,
        .footer {
            width: 100%;
            border-collapse: collapse;
        }

        .header {
            margin-bottom: 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        .header td {
            vertical-align: top;
            padding-bottom: 12px;
        }

        .header-right {
            width: 35%;
            text-align: right;
        }

        .eyebrow {
            margin: 0;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #6b7280;
        }

        .title {
            margin: 6px 0 0;
            font-size: 26px;
            line-height: 1.1;
            font-weight: 700;
            color: #0f172a;
        }

        .subtitle {
            margin: 6px 0 0;
            color: #4b5563;
            font-size: 12px;
        }

        .ref-label {
            margin: 0;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #6b7280;
        }

        .ref-value {
            margin: 4px 0 0;
            font-size: 13px;
            font-weight: 700;
            color: #111827;
        }

        .status {
            display: inline-block;
            margin-top: 8px;
            padding: 4px 10px;
            border: 1px solid #d1d5db;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #374151;
            background: #f9fafb;
        }

        .price {
            margin-bottom: 12px;
            padding: 12px;
            border-radius: 8px;
            background: #111827;
            color: #fff;
        }

        .price-label {
            margin: 0;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #d1d5db;
        }

        .price-value {
            margin: 6px 0 0;
            font-size: 24px;
            line-height: 1;
            font-weight: 700;
            color: #fff;
        }

        .price-currency {
            font-size: 13px;
            color: #d1d5db;
            font-weight: 500;
        }

        .section-label {
            margin: 10px 0 6px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #6b7280;
        }

        .images td {
            width: 50%;
            padding: 4px;
            vertical-align: top;
        }

        .image-frame {
            height: 160px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            background: #f8fafc;
            text-align: center;
            vertical-align: middle;
            overflow: hidden;
        }

        .image-frame img {
            max-width: 100%;
            max-height: 150px;
            vertical-align: middle;
        }

        .specs {
            margin-top: 2px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }

        .specs th,
        .specs td {
            padding: 9px 10px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: top;
        }

        .specs tr:last-child th,
        .specs tr:last-child td {
            border-bottom: 0;
        }

        .specs th {
            width: 36%;
            text-align: left;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #6b7280;
            background: #f9fafb;
        }

        .specs td {
            font-size: 12px;
            font-weight: 600;
            color: #111827;
        }

        .description {
            padding: 10px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            color: #374151;
        }

        .footer {
            margin-top: 14px;
            border-top: 1px solid #e5e7eb;
        }

        .footer td {
            padding-top: 8px;
            color: #6b7280;
            font-size: 9px;
        }

        .footer-right {
            text-align: right;
        }

    </style>
</head>

<body>
    @php
        $brandName = $machine->brand?->name ?? 'Sin marca';
        $modelName = $machine->model ?? 'Sin modelo';
        $machineCode = $machine->identifier_code ?? '---';

        $imageSource = null;
        $photos = collect(is_array($machine->photos) ? $machine->photos : [])->filter(fn ($p) => filled($p))->first();
        if ($photos) {
            $source = trim((string) $photos);
            if ($source !== '') {
                if (\Illuminate\Support\Str::startsWith($source, ['http://', 'https://'])) {
                    $imageSource = $source;
                } else {
                    $relativePath = ltrim($source, '/');
                    $storagePath = public_path('storage/' . $relativePath);
                    $imageSource = file_exists($storagePath) ? $storagePath : (file_exists(public_path($relativePath)) ? public_path($relativePath) : null);
                }
            }
        }

        $specifications = [
            [ucfirst(__('brand')), $brandName],
            [ucfirst(__('model')), $modelName],
            [ucfirst(__('work_hours')), number_format((int) ($machine->work_hours ?? 0), 0, ',', '.') . ' h'],
            [ucfirst(__('identifier_code')), $machineCode],
        ];
    @endphp

    <table class="header">
        <tr>
            <td>
                <p class="eyebrow">{{ ucfirst(__('product data sheet')) }}</p>
                <p class="title">{{ $modelName }}</p>
                <p class="subtitle">{{ $brandName }}</p>
            </td>

            <td class="header-right">
                <p class="ref-label">{{ ucfirst(__('identifier_code')) }}</p>
                <p class="ref-value">{{ $machineCode }}</p>

                @if($machine->sell_status)
                <span class="status">{{ $machine->sell_status->getLabel() }}</span>
                @endif
            </td>
        </tr>
    </table>

    <div class="price">
        <p class="price-label">{{ ucfirst(__('selling_price')) }}</p>
        <p class="price-value">
            {{ number_format((float) $machine->selling_price, 0, ',', '.') }}
            <span class="price-currency">EUR</span>
        </p>
    </div>

    @if($imageSource)
    <p class="section-label">{{ ucfirst(__('photos')) }}</p>

    <table class="images">
        <tr>
            <td>
                <div class="image-frame">
                    <img src="{{ $imageSource }}" alt="{{ $modelName }}">
                </div>
            </td>
        </tr>
    </table>
    @endif

    <table class="specs">
        @foreach($specifications as [$label, $value])
        <tr>
            <th>{{ $label }}</th>
            <td>{{ $value }}</td>
        </tr>
        @endforeach
    </table>

    @if($machine->description)
        <p class="section-label">{{ ucfirst(__('description')) }}</p>
        <div class="description">{!! $machine->description !!}</div>
    @endif

    <table class="footer">
        <tr>
            <td>{{ config('app.name') }}</td>
            <td class="footer-right">{{ ucfirst(__('created_at')) . ' ' . now()->format('d/m/Y') }}</td>
        </tr>
    </table>
</body>
</html>
