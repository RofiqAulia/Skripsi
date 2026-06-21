<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Plan Details</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            color: #1a1a1a;
            background: #fff;
            padding: 20px;
        }

        .header {
            border-bottom: 3px solid #1a1a1a;
            padding-bottom: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        .header h1 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 11px;
            color: #6b7280;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #1a1a1a;
            border-bottom: 1px solid #1a1a1a;
            padding-bottom: 5px;
            margin-bottom: 15px;
            margin-top: 25px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table th, .data-table td {
            border: 1px solid #e5e7eb;
            padding: 8px 10px;
            text-align: left;
        }
        .data-table th {
            background: #f9fafb;
            font-weight: 600;
            color: #374151;
        }
        .data-table td.amount {
            text-align: right;
        }

        .summary-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
        }
    </style>
</head>
<body>

    @php
        $user = $plan->user;
        $app = $plan->scholarshipApplication;
        $progStudy = $app?->programStudy;
        $items = $plan->items->groupBy('category');
    @endphp

    <div class="header">
        <h1>Financial Plan Breakdown</h1>
        <p>Submitted on {{ $plan->submitted_at ? \Carbon\Carbon::parse($plan->submitted_at)->format('d F Y') : now()->format('d F Y') }}</p>
    </div>

    <div class="section-title">Applicant & Study Plan Details</div>
    <table class="data-table">
        <tr>
            <th style="width: 30%;">Name</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>University</th>
            <td>{{ $plan->university_name ?? ($progStudy?->university ?? '-') }}</td>
        </tr>
        <tr>
            <th>Country</th>
            <td>{{ $plan->country_destination ?? ($progStudy?->country ?? '-') }}</td>
        </tr>
        <tr>
            <th>Study Duration</th>
            <td>{{ $plan->study_duration_month ? $plan->study_duration_month . ' Months' : '-' }}</td>
        </tr>
        <tr>
            <th>Currency</th>
            <td>{{ $plan->currency }}</td>
        </tr>
    </table>

    <div class="section-title">Financial Details by Category</div>

    @foreach($items as $category => $categoryItems)
        <h4 style="margin-bottom: 10px; color: #4b5563; text-transform: capitalize;">{{ $category }}</h4>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 40%;">Item</th>
                    <th style="width: 20%; text-align: right;">Estimated Cost</th>
                    <th style="width: 20%; text-align: right;">Scholarship Coverage</th>
                    <th style="width: 20%; text-align: right;">Gap Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $catTotalEst = 0;
                    $catTotalSchol = 0;
                    $catTotalGap = 0;
                @endphp
                @foreach($categoryItems as $item)
                    @php
                        $catTotalEst += $item->estimated_cost;
                        $catTotalSchol += $item->scholarship_coverage;
                        $catTotalGap += $item->gap_amount;
                    @endphp
                    <tr>
                        <td>{{ $item->item_name }}</td>
                        <td class="amount">{{ number_format($item->estimated_cost, 2) }}</td>
                        <td class="amount">{{ number_format($item->scholarship_coverage, 2) }}</td>
                        <td class="amount" style="color: {{ $item->gap_amount >= 0 ? '#16a34a' : '#dc2626' }};">{{ ($item->gap_amount >= 0 ? '+' : '') . number_format($item->gap_amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background: #f3f4f6; font-weight: bold;">
                    <td>Subtotal</td>
                    <td class="amount">{{ number_format($catTotalEst, 2) }}</td>
                    <td class="amount">{{ number_format($catTotalSchol, 2) }}</td>
                    <td class="amount" style="color: {{ $catTotalGap >= 0 ? '#16a34a' : '#dc2626' }};">{{ ($catTotalGap >= 0 ? '+' : '') . number_format($catTotalGap, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    @endforeach

    <div class="section-title">Summary</div>
    <div class="summary-box">
        <table style="width: 100%;">
            <tr>
                <td style="padding: 4px 0;">Total Estimated Cost</td>
                <td style="text-align: right;">{{ $plan->currency }} {{ number_format($plan->total_estimated_cost, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 4px 0;">Total Scholarship Funding</td>
                <td style="text-align: right; color: #16a34a;">{{ $plan->currency }} {{ number_format($plan->total_funding, 2) }}</td>
            </tr>
            <tr style="font-weight: bold; font-size: 14px;">
                <td style="padding: 8px 0; border-top: 1px solid #e5e7eb;">Funding Gap</td>
                <td style="text-align: right; color: {{ $plan->funding_gap >= 0 ? '#16a34a' : '#dc2626' }}; border-top: 1px solid #e5e7eb;">{{ ($plan->funding_gap >= 0 ? '+' : '') . $plan->currency }} {{ number_format($plan->funding_gap, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        This document is automatically generated by the Financial Plan system · {{ now()->format('d F Y H:i') }}
    </div>

</body>
</html>
