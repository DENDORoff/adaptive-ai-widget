<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ \App\Models\PageSection::getValue('dashboard', 'metadata', 'title', 'СИТУАЦИОННЫЙ ЦЕНТР VKEIK COLLEGE') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            margin: 0; 
            padding: 0; 
            background-color: #111827;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }
        * { box-sizing: border-box; }
        .tight-card { padding: 8px !important; }
        .chart-container { position: relative; width: 100%; height: 100%; }
        .main-container { 
            height: calc(100vh - 230px);
            min-height: 0;
            overflow: hidden;
            flex: 1;
        }
        .logo-container {
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .logo-container:hover {
            opacity: 0.8;
        }
        .account-item { padding: 8px 10px !important; min-height: 40px; }
        .tab-content {
            transition: transform 0.3s ease, opacity 0.3s ease;
        }
        .tab-content.slide-left {
            transform: translateX(-20px);
            opacity: 0;
        }
        .tab-content.slide-right {
            transform: translateX(20px);
            opacity: 0;
        }
        .tab-content.active {
            transform: translateX(0);
            opacity: 1;
        }
        .nav-arrow {
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 80px;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            cursor: pointer;
            z-index: 100;
            opacity: 0.3;
            transition: all 0.3s ease;
            border-radius: 4px;
        }
        .nav-arrow:hover {
            opacity: 0.8;
            background: rgba(59, 130, 246, 0.5);
        }
        .nav-arrow.left {
            left: 10px;
        }
        .nav-arrow.right {
            right: 10px;
        }
        .datetime-horizontal {
            display: flex;
            align-items: baseline;
            gap: 16px;
            white-space: nowrap;
        }
        .datetime-horizontal #clock {
            font-size: 28px;
            font-weight: bold;
            color: white;
        }
        .datetime-horizontal #date {
            font-size: 28px;
            font-weight: bold;
            color: #93c5fd;
        }
        .language-dropdown {
            position: relative;
            display: inline-block;
        }
        .language-dropdown-btn {
            background-color: rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.7);
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .language-dropdown-btn.active {
            background-color: white;
            color: #2563eb;
        }
        .language-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 120px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1000;
            border-radius: 4px;
            overflow: hidden;
        }
        .language-dropdown-content.show {
            display: block;
        }
        .language-dropdown-content a {
            color: #374151;
            padding: 10px 16px;
            text-decoration: none;
            display: block;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.2s;
        }
        .language-dropdown-content a:hover {
            background-color: #f3f4f6;
            color: #2563eb;
        }
        .language-dropdown-content a.active {
            background-color: #2563eb;
            color: white;
        }
        .block-with-icon {
            position: relative;
            padding: 15px;
            height: 100%;
            display: flex;
            flex-direction: column;
            min-height: 120px;
        }
        .block-icon-text-container {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 10px;
            flex: 1;
        }
        .block-icon {
            font-size: 2rem;
            flex-shrink: 0;
        }
        .block-text {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1f2937;
            line-height: 1.3;
        }
        .block-number {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.1;
            text-align: right;
            margin-top: auto;
        }
        .tab-button {
            padding: 8px 16px;
            font-size: 0.9rem;
            min-height: 45px;
            flex: 1;
        }
        .tabs-container {
            display: flex;
            width: 100%;
            justify-content: space-between;
            gap: 2px;
        }
        .dashboard-footer {
            height: 40px;
            background: linear-gradient(to right, #1e293b, #334155);
            border-top: 2px solid #475569;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 40;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
        }
        .social-analytics-container {
            display: flex;
            height: 100%;
            gap: 20px;
            padding: 8px;
        }
        .social-left-block {
            flex: 1;
            background: white;
            border-radius: 8px;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        .social-center-block {
            flex: 1;
            background: white;
            border-radius: 8px;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        .social-right-block {
            flex: 1;
            background: white;
            border-radius: 8px;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        .analytics-title {
            font-size: 20px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 15px;
            text-align: center;
        }
        .social-icons-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(2, auto);
            gap: 15px;
            flex: 1;
            align-items: center;
            justify-items: center;
        }
        .social-icon-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 140px;
        }
        .social-icon-circle {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }
        .social-icon {
            font-size: 32px;
            color: white;
        }
        .social-count {
            font-size: 28px;
            font-weight: 800;
            color: #1f2937;
            text-align: center;
        }
        .social-name {
            font-size: 18px;
            color: #6b7280;
            margin-top: 6px;
            text-align: center;
        }
        .telegram-bg {
            background: linear-gradient(135deg, #0088cc, #00a2e8);
        }
        .instagram-bg {
            background: linear-gradient(45deg, #405DE6, #5B51D8, #833AB4, #C13584, #E1306C, #FD1D1D, #F56040, #F77737, #FCAF45, #FFDC80);
        }
        .youtube-bg {
            background: linear-gradient(135deg, #FF0000, #FF3333);
        }
        .empty-bg {
            background: #f3f4f6;
            visibility: hidden;
        }
        .donut-chart-container {
            flex: 1;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 0;
        }
        .portal-chart-container {
            flex: 1;
            position: relative;
            min-height: 0;
        }
        .social-legend {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 8px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .legend-color {
            width: 10px;
            height: 10px;
            border-radius: 2px;
        }
        .legend-text {
            font-size: 12px;
            color: #374151;
            font-weight: 500;
        }
        .weather-widget {
            display: flex;
            align-items: center;
            gap: 8px;
            color: white;
            font-size: 14px;
            font-weight: bold;
            padding-left: 15px;
            position: relative;
        }
        .weather-widget::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 1px;
            height: 16px;
            background-color: rgba(255, 255, 255, 0.3);
        }
        .weather-icon {
            font-size: 16px;
            color: white;
        }
        .weather-temp {
            font-size: 14px;
            font-weight: bold;
            color: white;
        }
        .logo-title {
            font-size: 20px;
            font-weight: bold;
            color: white;
        }
        .logo-img {
            width: 35px;
            height: 35px;
        }
        .personal-accounts-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 6px;
            background: linear-gradient(135deg, #3B82F6, #1D4ED8);
            border-radius: 5px;
            margin-top: 6px;
            color: white;
        }
        .personal-accounts-total {
            font-size: 20px;
            font-weight: bold;
        }
        .personal-accounts-label {
            font-size: 12px;
            opacity: 0.9;
        }
        .footer-container {
            flex-shrink: 0;
            margin-top: auto;
        }
        .vertical-infrastructure-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
            height: 100%;
            min-height: 0;
        }
        .vertical-infrastructure-card {
            background: white;
            border-radius: 8px;
            padding: 10px;
            border: 1px solid #e5e7eb;
            flex: 1;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            min-height: 70px;
        }
        .infrastructure-icon-text-wrapper {
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1;
        }
        .infrastructure-icon-circle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0;
        }
        .infrastructure-icon-circle.green-bg {
            background-color: #0d9488;
        }
        .infrastructure-icon-circle.blue-bg {
            background-color: #2563eb;
        }
        .infrastructure-icon-circle.purple-bg {
            background-color: #8B5CF6;
        }
        .infrastructure-icon {
            font-size: 16px;
            color: white;
        }
        .infrastructure-text {
            font-size: 16px;
            font-weight: 500;
            color: #1f2937;
            line-height: 1.2;
        }
        .infrastructure-value {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
            text-align: right;
        }
        .infrastructure-value.green {
            color: #0d9488;
        }
        .infrastructure-value.blue {
            color: #2563eb;
        }
        .infrastructure-value.purple {
            color: #8B5CF6;
        }
        .infrastructure-unit {
            font-size: 12px;
            color: #6b7280;
            margin-left: 2px;
        }
        .chart-title-small {
            font-size: 1.1rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 3px;
            line-height: 1.2;
        }
        .nested-legend {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 5px;
            flex-wrap: wrap;
        }
        .legend-square {
            width: 10px;
            height: 10px;
            border-radius: 2px;
            margin-right: 3px;
        }
        .legend-item-compact {
            display: flex;
            align-items: center;
            font-size: 12px;
            font-weight: bold;
            color: #374151;
        }
        .small-block-container {
            padding: 5px;
            margin: 2px 0;
            border-radius: 5px;
        }
        .small-block-icon {
            font-size: 1.3rem;
            margin-bottom: 2px;
        }
        .small-block-number {
            font-size: 1.5rem;
            margin: 2px 0;
        }
        .small-block-label {
            font-size: 0.8rem;
            line-height: 1;
        }
        .stats-row {
            padding: 3px;
            margin: 2px 0;
            border-radius: 5px;
        }
        .stats-number {
            font-size: 1.2rem;
        }
        .stats-label {
            font-size: 0.7rem;
        }
        .labs-expanded-block {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 90px;
            background-color: white;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: center;
        }
        .labs-expanded-block .text-3xl {
            font-size: 1.7rem;
            margin-top: 4px;
        }
        .teachers-foreign-block {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 90px;
            background-color: white;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: center;
        }
        .teachers-foreign-block .text-3xl {
            font-size: 1.7rem;
            margin-top: 4px;
        }
        .dual-learning-block {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 90px;
            background-color: white;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: center;
        }
        .dual-learning-block .text-3xl {
            font-size: 1.7rem;
            margin-top: 4px;
        }
        .teachers-training-block {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 90px;
            background-color: white;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: center;
        }
        .teachers-training-block .text-3xl {
            font-size: 1.7rem;
            margin-top: 4px;
        }
        .medal-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .medal-icon {
            font-size: 16px;
            margin-bottom: 2px;
        }
        .medal-gold { color: #FFD700; }
        .medal-silver { color: #C0C0C0; }
        .medal-bronze { color: #CD7F32; }
        .medal-other { color: #8B5CF6; }
        .ipr-stat-item {
            padding: 2px 4px;
            margin-bottom: 1px;
            border-radius: 4px;
        }
        .chart-text-values-bottom {
            position: absolute;
            bottom: -35px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-around;
            z-index: 10;
        }
        .chart-text-value-bottom {
            font-size: 18px;
            font-weight: bold;
            color: #374151;
            text-align: center;
            min-width: 60px;
            padding: 4px 6px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transform: none !important;
        }
        .big-donut-chart {
            height: 220px !important;
        }
        .large-donut-chart {
            height: 200px !important;
        }
        .xlarge-donut-chart {
            height: 220px !important;
        }
        .compact-grid-2 {
            grid-template-columns: repeat(2, 1fr);
            gap: 4px;
        }
        .compact-padding {
            padding: 3px;
        }
        .level-card {
            min-height: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .level-title {
            line-height: 1;
            font-size: 0.8rem;
            padding: 0 2px;
        }
        .grid-3col-tight {
            grid-template-columns: 1fr 1.2fr 1fr;
            gap: 6px;
            min-height: 0;
            overflow: hidden;
        }
        .grid-2col-tight {
            grid-template-columns: 1.1fr 0.9fr;
            gap: 6px;
        }
        .portal-stats {
            margin-top: 6px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            gap: 12px;
        }
        .portal-stat-item {
            text-align: center;
            flex: 1;
        }
        .admin-top-row {
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            height: 30%;
            min-height: 0;
            overflow: hidden;
            margin-bottom: 6px;
            flex-shrink: 0;
        }
        .admin-bottom-row {
            flex: 1;
            min-height: 0;
            overflow: hidden;
        }
        .ipr-quality-container {
            display: flex;
            flex-direction: column;
            height: 100%;
            min-height: 0;
        }
        .ipr-chart-container {
            height: 170px;
            flex-shrink: 0;
        }
        .ipr-stats-container {
            flex: 1;
            min-height: 0;
            padding-top: 2px;
        }
        .it-cluster-grid {
            display: grid;
            grid-template-rows: 1fr 1fr;
            gap: 6px;
            height: 100%;
            min-height: 0;
            overflow: hidden;
        }
        .it-cluster-top-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            min-height: 0;
        }
        .it-cluster-bottom-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            min-height: 0;
        }
        .human-resources-block {
            background: white;
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #e5e7eb;
            min-height: 0;
            display: flex;
            flex-direction: column;
        }
        .human-resources-stats {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
        }
        .human-resource-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .human-resource-item:last-child {
            border-bottom: none;
        }
        .building-people-block {
            background: white;
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #e5e7eb;
            min-height: 0;
            display: flex;
        }
        .building-chart-container {
            flex: 1;
            position: relative;
        }
        .building-numbers-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-top: 8px;
        }
        .building-number-item {
            text-align: center;
            padding: 6px;
            background: #f9fafb;
            border-radius: 5px;
        }
        .events-donut-chart {
            height: 220px !important;
        }
        .building-content-wrapper {
            display: flex;
            flex-direction: column;
            flex: 1;
            padding-right: 12px;
        }
        .building-stats-grid {
            margin-top: 12px;
        }
        .nested-legend-extended {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 8px;
            flex-wrap: wrap;
        }
        .legend-item-extended {
            display: flex;
            align-items: center;
            font-size: 12px;
            font-weight: bold;
            color: #374151;
        }
        .employment-chart-container {
            padding-top: 12px;
        }
        .chart-legend-spacing {
            margin-top: 8px;
        }
        .chart-legend-centered {
            margin-top: 8px;
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        .chart-data-labels {
            font-size: 20px;
            font-weight: bold;
            color: white;
        }
        .compact-chart-container {
            flex: 1;
            position: relative;
            height: 220px;
            margin-bottom: 5px;
        }
        .ipr-compact-chart-container {
            flex: 1;
            position: relative;
            height: 170px;
            margin-bottom: 2px;
        }
        .ipr-compact-stats {
            flex: 1;
            min-height: 0;
            padding-top: 0;
        }
        .ipr-total-row {
            padding: 0 4px;
            margin-top: 4px;
            border-top: 1px solid #e5e7eb;
        }
        .ipr-total-label {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
        }
        .ipr-total-value {
            font-size: 22px;
            font-weight: bold;
            color: #111827;
        }
        .ipr-chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .ipr-title-wrapper {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .ipr-total-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .ipr-stats-wrapper {
            flex: 1;
            min-height: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .ipr-stats-scroll {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            padding-right: 2px;
        }
        .ipr-stats-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .ipr-stats-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 2px;
        }
        .ipr-stats-scroll::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 2px;
        }
        .ipr-stat-text {
            font-size: 11px;
            font-weight: bold;
            color: #1f2937;
            line-height: 1.1;
        }
        .ipr-quality-stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 4px;
            margin-top: 4px;
        }
        .ipr-stat-box {
            background: #f9fafb;
            border-radius: 4px;
            padding: 6px;
            text-align: center;
        }
        .chart-percent-inside {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            pointer-events: none;
        }
        .datalabels-container {
            position: relative;
            width: 100%;
            height: 100%;
        }
        .contingent-chart-wrapper {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .contingent-chart-content {
            display: flex;
            height: 100%;
            min-height: 0;
        }
        .contingent-chart-left {
            flex: 1;
            position: relative;
            height: 100%;
        }
        .contingent-legend-right {
            width: 140px;
            padding-left: 8px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .admission-chart-wrapper {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .admission-chart-content {
            display: flex;
            height: 100%;
            min-height: 0;
        }
        .admission-chart-left {
            flex: 1;
            position: relative;
            height: 100%;
        }
        .admission-legend-right {
            width: 140px;
            padding-left: 8px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .right-legend-container {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .right-legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 6px;
        }
        .right-legend-square {
            width: 12px;
            height: 12px;
            border-radius: 2px;
            margin-right: 8px;
            flex-shrink: 0;
        }
        .right-legend-text {
            font-size: 12px;
            font-weight: bold;
            color: #374151;
            white-space: nowrap;
        }
        .employment-chart-wrapper {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .employment-chart-content {
            display: flex;
            height: 100%;
            min-height: 0;
        }
        .employment-legend-left {
            width: 140px;
            padding-right: 8px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .employment-chart-right {
            flex: 1;
            position: relative;
            height: 100%;
        }
        .ipr-chart-wrapper {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .ipr-chart-content {
            display: flex;
            height: 100%;
            min-height: 0;
        }
        .ipr-legend-left {
            width: 140px;
            padding-right: 8px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .ipr-chart-right {
            flex: 1;
            position: relative;
            height: 100%;
        }
        .left-legend-container {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .left-legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 6px;
        }
        .left-legend-square {
            width: 12px;
            height: 12px;
            border-radius: 2px;
            margin-right: 8px;
            flex-shrink: 0;
        }
        .left-legend-text {
            font-size: 12px;
            font-weight: bold;
            color: #374151;
            white-space: nowrap;
        }
        .departments-full-names {
            font-size: 12px;
            font-weight: bold;
            color: #374151;
            line-height: 1;
            text-align: center;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            max-height: 30px;
        }
        .ideology-blocks-row {
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            height: 30%;
            min-height: 0;
            overflow: hidden;
        }
        .academic-four-blocks-container {
            display: flex;
            flex-direction: row;
            gap: 8px;
            margin-top: 8px;
            height: 220px;
        }
        .academic-left-blocks {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .academic-right-blocks {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .academic-dual-training-block {
            min-height: 106px;
            flex: 1;
        }
        .academic-teachers-training-block {
            min-height: 106px;
            flex: 1;
        }
        .academic-labs-block {
            min-height: 106px;
            flex: 1;
        }
        .academic-foreign-teachers-block {
            min-height: 106px;
            flex: 1;
        }
        .it-cluster-vertical-container {
            display: flex;
            flex-direction: column;
            height: 100%;
            min-height: 0;
            overflow: hidden;
        }
        .departments-labels-container {
            display: flex;
            justify-content: space-between;
            padding: 0 5px;
            margin-top: 3px;
            gap: 2px;
        }
        .department-label-item {
            flex: 1;
            max-width: 23%;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .department-short-name {
            font-size: 10px;
            font-weight: bold;
            color: #6b7280;
            margin-top: 2px;
        }
        .department-full-name {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
            line-height: 1.1;
            min-height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .department-label-item:first-child {
            margin-left: 40px;
        }
        .weather-widget-container {
            margin-right: 20px;
        }
        .language-buttons-container {
            display: flex;
            gap: 5px;
            align-items: center;
        }
        .language-btn {
            background-color: rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.7);
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }
        .language-btn:hover {
            background-color: rgba(255, 255, 255, 0.3);
            color: white;
        }
        .language-btn.active {
            background-color: white;
            color: #2563eb;
        }
        .footer-weather-widget {
            display: flex;
            align-items: center;
            gap: 8px;
            color: white;
            font-size: 14px;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-gray-900 m-0 p-0">
<div class="h-screen flex flex-col bg-gray-900 overflow-hidden" x-data="dashboard()">
    
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-4 shadow-lg flex-shrink-0">
        <div class="px-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <a href="/" class="logo-container flex items-center gap-3 no-underline">
                        <div class="logo-img rounded-full flex items-center justify-center">
                            <img src="{{ asset('images/logo.png') }}">
                        </div>
                        <div class="flex items-center gap-2">
                            <h1 class="logo-title leading-tight text-2xl">{{ \App\Models\PageSection::getValue('dashboard', 'header', 'title', 'СИТУАЦИОННЫЙ ЦЕНТР') }}</h1>
                        </div>
                    </a>
                </div>
                
                <div class="flex items-center gap-3">
                    <a href="/" class="flex items-center gap-2 bg-blue-800 hover:bg-blue-900 text-white px-4 py-2 rounded-lg text-sm font-semibold transition no-underline">
                        <i class="fas fa-arrow-left text-sm"></i>
                        <span>На главную сайта</span>
                    </a>
                    
                    <div class="datetime-horizontal text-right">
                        <div id="clock" class="text-xl font-bold leading-tight"></div>
                        <div id="date" class="text-blue-200 text-xl"></div>
                    </div>
                    
                    <div class="language-buttons-container">
                        <a href="{{ route('locale.switch', 'kk') }}" class="language-btn {{ app()->getLocale() == 'kk' ? 'active' : '' }}" title="Қазақша">{{ \App\Models\PageSection::getValue('header', 'languages', 'kaz_label', 'ҚАЗ') }}</a>
                        <a href="{{ route('locale.switch', 'ru') }}" class="language-btn {{ app()->getLocale() == 'ru' ? 'active' : '' }}" title="Русский">{{ \App\Models\PageSection::getValue('header', 'languages', 'rus_label', 'РУС') }}</a>
                        <a href="{{ route('locale.switch', 'en') }}" class="language-btn {{ app()->getLocale() == 'en' ? 'active' : '' }}" title="English">{{ \App\Models\PageSection::getValue('header', 'languages', 'eng_label', 'ENG') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-800 text-white shadow-md flex-shrink-0 py-1">
        <div class="px-2">
            <div class="tabs-container">
                <button @click="switchTab('academic', 'left')" 
                        :class="activeTab === 'academic' ? 'bg-blue-600' : 'hover:bg-gray-700'"
                        class="flex items-center justify-center gap-1 px-1 py-2 transition rounded-t tab-button">
                    <i class="fas fa-graduation-cap text-sm"></i>
                    <span class="font-semibold text-sm">{{ \App\Models\PageSection::getValue('dashboard', 'tabs', 'academic', 'АКАДЕМИЧЕСКАЯ ДЕЯТЕЛЬНОСТЬ') }}</span>
                </button>

                <button @click="switchTab('events', 'left')" 
                        :class="activeTab === 'events' ? 'bg-blue-600' : 'hover:bg-gray-700'"
                        class="flex items-center justify-center gap-1 px-1 py-2 transition rounded-t tab-button">
                    <i class="fas fa-users text-sm"></i>
                    <span class="font-semibold text-sm">{{ \App\Models\PageSection::getValue('dashboard', 'tabs', 'ideology', 'ИДЕОЛОГИЧЕСКАЯ ДЕЯТЕЛЬНОСТЬ') }}</span>
                </button>

                <button @click="switchTab('services', 'left')" 
                        :class="activeTab === 'services' ? 'bg-blue-600' : 'hover:bg-gray-700'"
                        class="flex items-center justify-center gap-1 px-1 py-2 transition rounded-t tab-button">
                    <i class="fas fa-cogs text-sm"></i>
                    <span class="font-semibold text-sm">{{ \App\Models\PageSection::getValue('dashboard', 'tabs', 'admin', 'АДМИНИСТРАТИВНАЯ ДЕЯТЕЛЬНОСТЬ') }}</span>
                </button>

                <button @click="switchTab('tech', 'left')" 
                        :class="activeTab === 'tech' ? 'bg-blue-600' : 'hover:bg-gray-700'"
                        class="flex items-center justify-center gap-1 px-1 py-2 transition rounded-t tab-button">
                    <i class="fas fa-laptop-code text-sm"></i>
                    <span class="font-semibold text-sm">{{ \App\Models\PageSection::getValue('dashboard', 'tabs', 'it_cluster', 'IT CLUSTER') }}</span>
                </button>
            </div>
        </div>
    </div>

    <div class="nav-arrow left" @click="previousTab">
        <i class="fas fa-chevron-left"></i>
    </div>

    <div class="nav-arrow right" @click="nextTab">
        <i class="fas fa-chevron-right"></i>
    </div>

    <div class="flex-1 p-2 main-container relative overflow-hidden">
        
        <div x-show="activeTab === 'academic'" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-x-full"
             x-transition:enter-end="opacity-100 transform translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-x-0"
             x-transition:leave-end="opacity-0 transform -translate-x-full"
             class="h-full absolute inset-0 p-2 overflow-hidden">
            
            <div class="grid grid-3col-tight h-full overflow-hidden">
                
                <div class="flex flex-col gap-2 overflow-hidden">
                    <div class="bg-white rounded-lg tight-card border border-gray-300 flex-1 min-h-0 contingent-chart-wrapper">
                        <h3 class="chart-title-small text-gray-800 mb-1 flex items-center gap-1">
                            <i class="fas fa-users text-blue-600 text-xs"></i>
                            {{ \App\Models\PageSection::getValue('dashboard', 'academic', 'contingent_title', 'Контингент (ГЗ / ЦГЗ / платно)') }}
                        </h3>
                        <div class="contingent-chart-content">
                            <div class="contingent-chart-left">
                                <canvas id="contingentChart"></canvas>
                            </div>
                            <div class="contingent-legend-right">
                                <div class="right-legend-container">
                                    <div class="right-legend-item">
                                        <div class="right-legend-square" style="background-color: #8B5CF6;"></div>
                                        <span class="right-legend-text">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'gz_label', 'ГЗ') }}</span>
                                    </div>
                                    <div class="right-legend-item">
                                        <div class="right-legend-square" style="background-color: #2563EB;"></div>
                                        <span class="right-legend-text">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'gz_cgz_label', 'ГЗ+ЦГЗ') }}</span>
                                    </div>
                                    <div class="right-legend-item">
                                        <div class="right-legend-square" style="background-color: #10B981;"></div>
                                        <span class="right-legend-text">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'cgz_label', 'ЦГЗ') }}</span>
                                    </div>
                                    <div class="right-legend-item">
                                        <div class="right-legend-square" style="background-color: #F97316;"></div>
                                        <span class="right-legend-text">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'paid_label', 'Платно') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg tight-card border border-gray-300 flex-1 min-h-0 admission-chart-wrapper">
                        <h3 class="chart-title-small text-gray-800 mb-1 flex items-center gap-1">
                            <i class="fas fa-user-plus text-green-600 text-xs"></i>
                            {{ \App\Models\PageSection::getValue('dashboard', 'academic', 'admission_title', 'Новый прием (ГЗ / ЦГЗ / платно)') }}
                        </h3>
                        <div class="admission-chart-content">
                            <div class="admission-chart-left">
                                <canvas id="admissionChart"></canvas>
                            </div>
                            <div class="admission-legend-right">
                                <div class="right-legend-container">
                                    <div class="right-legend-item">
                                        <div class="right-legend-square" style="background-color: #8B5CF6;"></div>
                                        <span class="right-legend-text">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'gz_label', 'ГЗ') }}</span>
                                    </div>
                                    <div class="right-legend-item">
                                        <div class="right-legend-square" style="background-color: #2563EB;"></div>
                                        <span class="right-legend-text">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'gz_cgz_label', 'ГЗ+ЦГЗ') }}</span>
                                    </div>
                                    <div class="right-legend-item">
                                        <div class="right-legend-square" style="background-color: #10B981;"></div>
                                        <span class="right-legend-text">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'cgz_label', 'ЦГЗ') }}</span>
                                    </div>
                                    <div class="right-legend-item">
                                        <div class="right-legend-square" style="background-color: #F97316;"></div>
                                        <span class="right-legend-text">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'paid_label', 'Платно') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid compact-grid-2 gap-2">
                        <div class="bg-white rounded-lg compact-padding border border-gray-300 text-center flex flex-col items-center justify-center small-block-container">
                            <i class="fas fa-briefcase text-purple-600 small-block-icon"></i>
                            <div class="small-block-number font-bold text-purple-600 leading-none" data-stat-key="academic_specialties">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'specialties_value', '0') }}</div>
                            <p class="text-purple-600 small-block-label font-medium">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'specialties_label', 'Специальности') }}</p>
                        </div>

                        <div class="bg-blue-50 rounded-lg compact-padding border border-blue-200 text-center flex flex-col items-center justify-center small-block-container">
                            <i class="fas fa-laptop text-blue-600 small-block-icon"></i>
                            <div class="small-block-number font-bold text-blue-600 leading-none" data-stat-key="academic_distance_learning">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'distance_learning_value', '0') }}</div>
                            <div class="small-block-label text-gray-600 leading-tight font-medium">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'distance_learning_label', 'Поступившие на дистанционное обучение') }}</div>
                        </div>

                        <div class="bg-blue-50 rounded-lg compact-padding border border-blue-200 text-center flex flex-col items-center justify-center small-block-container">
                            <i class="fas fa-certificate text-blue-600 small-block-icon"></i>
                            <div class="small-block-number font-bold text-blue-600 leading-none" data-stat-key="academic_foreign_students">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'foreign_students_value', '0') }}</div>
                            <div class="small-block-label text-gray-600 leading-tight font-medium">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'foreign_students_label', 'Обучающиеся иностранные граждане') }}</div>
                        </div>

                        <div class="bg-green-50 rounded-lg compact-padding border border-green-200 text-center flex flex-col items-center justify-center small-block-container">
                            <i class="fas fa-award text-green-600 small-block-icon"></i>
                            <div class="small-block-number font-bold text-green-600 leading-none" data-stat-key="academic_honors_diplomas">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'honors_diplomas_value', '0') }}</div>
                            <div class="small-block-label text-gray-600 leading-tight font-medium">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'honors_diplomas_label', 'Окончившие колледж с дипломом с отличием') }}</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg tight-card border border-gray-300 flex flex-col min-h-0 overflow-hidden">
                    <h3 class="chart-title-small text-gray-800 mb-2 flex items-center gap-1">
                        <i class="fas fa-building text-teal-600 text-xs"></i>
                        {{ \App\Models\PageSection::getValue('dashboard', 'academic', 'departments_title', 'Студенты по отделениям и уровням') }}
                    </h3>
                    
                    <div class="chart-container flex-1 mb-1 min-h-0" style="height: 140px;">
                        <canvas id="departmentsChart"></canvas>
                    </div>

                    <div class="departments-labels-container">
                        <div class="department-label-item">
                            <div class="department-full-name">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'department_op', 'ОП, АТ и С') }}</div>
                        </div>
                        <div class="department-label-item">
                            <div class="department-full-name">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'department_vh', 'ВХ и ПХ, АД') }}</div>
                        </div>
                        <div class="department-label-item">
                            <div class="department-full-name">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'department_it', 'IT-отделение') }}</div>
                        </div>
                        <div class="department-label-item">
                            <div class="department-full-name">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'department_ozo', 'ОЗО') }}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-1 mt-2 flex-shrink-0">
                        <div class="bg-blue-100 rounded-lg compact-padding border border-blue-300 text-center level-card stats-row">
                            <div class="text-xs text-blue-700 font-bold mb-1 level-title">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'work_qualification_label', 'Рабочая квалификация') }}</div>
                            <div class="stats-number font-bold text-blue-600 leading-none" data-stat-key="academic_work_qualification">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'work_qualification_value', '0') }}</div>
                            <div class="stats-label text-blue-600 font-medium">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'students_label', 'обучающихся') }}</div>
                        </div>
                        
                        <div class="bg-green-100 rounded-lg compact-padding border border-green-300 text-center level-card stats-row">
                            <div class="text-xs text-green-700 font-bold mb-1 level-title">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'mid_specialist_label', 'Специалист среднего звена') }}</div>
                            <div class="stats-number font-bold text-green-600 leading-none" data-stat-key="academic_mid_specialist">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'mid_specialist_value', '0') }}</div>
                            <div class="stats-label text-green-600 font-medium">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'students_label', 'обучающихся') }}</div>
                        </div>
                        
                        <div class="bg-orange-100 rounded-lg compact-padding border border-orange-300 text-center level-card stats-row">
                            <div class="text-xs text-orange-700 font-bold mb-1 level-title">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'applied_bachelor_label', 'Прикладной бакалавр') }}</div>
                            <div class="stats-number font-bold text-orange-600 leading-none" data-stat-key="academic_applied_bachelor">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'applied_bachelor_value', '0') }}</div>
                            <div class="stats-label text-orange-600 font-medium">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'students_label', 'обучающихся') }}</div>
                        </div>
                    </div>

                    <div class="mt-2 pt-2 border-t border-gray-300 flex-shrink-0">
                        <h3 class="chart-title-small text-gray-800 mb-2 flex items-center gap-1">
                            <i class="fas fa-trophy text-yellow-600 text-xs"></i>
                            {{ \App\Models\PageSection::getValue('dashboard', 'academic', 'contests_title', 'Конкурсы профмастерства') }}
                        </h3>
                        <div class="grid grid-cols-4 gap-1">
                            <div class="text-center medal-item">
                                <i class="fas fa-medal medal-icon medal-gold"></i>
                                <div class="stats-number font-bold text-yellow-600 leading-none" data-stat-key="academic_contests_first">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'gold_value', '0') }}</div>
                                <div class="stats-label text-gray-600 font-medium">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'gold_label', 'Золото') }}</div>
                            </div>
                            <div class="text-center medal-item">
                                <i class="fas fa-medal medal-icon medal-silver"></i>
                                <div class="stats-number font-bold text-gray-600 leading-none" data-stat-key="academic_contests_second">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'silver_value', '0') }}</div>
                                <div class="stats-label text-gray-600 font-medium">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'silver_label', 'Серебро') }}</div>
                            </div>
                            <div class="text-center medal-item">
                                <i class="fas fa-medal medal-icon medal-bronze"></i>
                                <div class="stats-number font-bold text-orange-600 leading-none" data-stat-key="academic_contests_third">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'bronze_value', '0') }}</div>
                                <div class="stats-label text-gray-600 font-medium">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'bronze_label', 'Бронза') }}</div>
                            </div>
                            <div class="text-center medal-item">
                                <i class="fas fa-award medal-icon medal-other"></i>
                                <div class="stats-number font-bold text-purple-600 leading-none" data-stat-key="academic_contests_medals">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'medallions_value', '0') }}</div>
                                <div class="stats-label text-gray-600 font-medium">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'medallions_label', 'Медальоны') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2 overflow-hidden">
                    <div class="bg-white rounded-lg tight-card border border-gray-300 flex-1 min-h-0 employment-chart-wrapper">
                        <h3 class="chart-title-small text-gray-800 mb-1 flex items-center gap-1">
                            <i class="fas fa-briefcase text-green-600 text-xs"></i>
                            {{ \App\Models\PageSection::getValue('dashboard', 'academic', 'employment_title', 'Трудоустройство выпускников') }}
                        </h3>
                        <div class="employment-chart-content">
                            <div class="employment-legend-left">
                                <div class="left-legend-container">
                                    <div class="left-legend-item">
                                        <div class="left-legend-square" style="background-color: #10B981;"></div>
                                        <span class="left-legend-text">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'employed_label', 'Трудоустроены') }}</span>
                                    </div>
                                    <div class="left-legend-item">
                                        <div class="left-legend-square" style="background-color: #3B82F6;"></div>
                                        <span class="left-legend-text">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'studying_label', 'Учёба / декрет / армия') }}</span>
                                    </div>
                                    <div class="left-legend-item">
                                        <div class="left-legend-square" style="background-color: #EF4444;"></div>
                                        <span class="left-legend-text">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'unemployed_label', 'Не трудоустроены') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="employment-chart-right">
                                <canvas id="employmentChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg tight-card border border-gray-300 flex-1 min-h-0 ipr-chart-wrapper">
                        <div class="ipr-chart-header">
                            <div class="ipr-title-wrapper">
                                <i class="fas fa-user-tie text-blue-600 text-xs"></i>
                                <h3 class="chart-title-small text-gray-800">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'ipr_title', 'Качественный состав ИПР') }}</h3>
                            </div>
                            <div class="ipr-total-wrapper">
                                <span class="ipr-total-label">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'total_ipr_label', 'Всего ИПР:') }}</span>
                                <span class="ipr-total-value" data-stat-key="academic_total_ipr">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'total_ipr_value', '0') }}</span>
                            </div>
                        </div>
                        
                        <div class="ipr-chart-content">
                            <div class="ipr-legend-left">
                                <div class="left-legend-container">
                                    <div class="left-legend-item">
                                        <div class="left-legend-square" style="background-color: #8B5CF6;"></div>
                                        <span class="left-legend-text">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'researcher_label', 'Педагог-исследователь') }}</span>
                                    </div>
                                    <div class="left-legend-item">
                                        <div class="left-legend-square" style="background-color: #3B82F6;"></div>
                                        <span class="left-legend-text">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'expert_label', 'Педагог-эксперт') }}</span>
                                    </div>
                                    <div class="left-legend-item">
                                        <div class="left-legend-square" style="background-color: #6B7280;"></div>
                                        <span class="left-legend-text">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'moderator_label', 'Педагог-модератор') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="ipr-chart-right">
                                <canvas id="iprQualityChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="academic-four-blocks-container">
                        <div class="academic-left-blocks">
                            <div class="bg-white rounded-lg border border-gray-300 flex flex-col items-center justify-center academic-dual-training-block">
                                <i class="fas fa-handshake text-blue-600 text-2xl mb-1"></i>
                                <div class="text-2xl font-bold text-blue-600 leading-none" data-stat-key="academic_dual_learning_coverage">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'dual_learning_value', '0') }}</div>
                                <div class="text-sm text-gray-600 mt-1 font-bold text-center px-1">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'dual_learning_label', 'Охват дуальным обучением от ГЗ') }}</div>
                            </div>

                            <div class="bg-white rounded-lg border border-gray-300 flex flex-col items-center justify-center academic-teachers-training-block">
                                <i class="fas fa-chalkboard-teacher text-green-600 text-2xl mb-1"></i>
                                <div class="text-2xl font-bold text-green-600 leading-none" data-stat-key="academic_teachers_advanced_training">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'teachers_training_value', '0') }}</div>
                                <div class="text-sm text-gray-600 mt-1 font-bold text-center px-1">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'teachers_training_label', 'Количество преподавателей, прошедших повышение квалификации') }}</div>
                            </div>
                        </div>

                        <div class="academic-right-blocks">
                            <div class="bg-white rounded-lg border border-gray-300 flex flex-col items-center justify-center academic-labs-block">
                                <i class="fas fa-flask text-purple-600 text-2xl mb-1"></i>
                                <div class="text-2xl font-bold text-purple-600 leading-none" data-stat-key="academic_laboratories_count">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'labs_value', '0') }}</div>
                                <div class="text-sm text-gray-600 mt-1 font-bold text-center px-1">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'labs_label', 'Количество учебных кабинетов и лабораторий') }}</div>
                            </div>

                            <div class="bg-white rounded-lg border border-gray-300 flex flex-col items-center justify-center academic-foreign-teachers-block">
                                <i class="fas fa-language text-orange-600 text-2xl mb-1"></i>
                                <div class="text-2xl font-bold text-orange-600 leading-none" data-stat-key="academic_foreign_language_teachers">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'foreign_teachers_value', '0') }}</div>
                                <div class="text-sm text-gray-600 mt-1 font-bold text-center px-1">{{ \App\Models\PageSection::getValue('dashboard', 'academic', 'foreign_teachers_label', 'Преподаватели, владеющие иностранными языками') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'events'" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-x-full"
             x-transition:enter-end="opacity-100 transform translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-x-0"
             x-transition:leave-end="opacity-0 transform -translate-x-full"
             class="h-full absolute inset-0 p-2 overflow-hidden">
            
            <div class="h-full overflow-hidden flex flex-col">
                <div class="bg-white rounded-lg border border-gray-300 flex-1 min-h-0 mb-2">
                    <div class="social-analytics-container h-full">
                        <div class="social-left-block">
                            <h3 class="analytics-title">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'social_title', 'Количество подписчиков в соцсетях колледжа') }}</h3>
                            <div class="social-icons-grid">
                                <div class="social-icon-item">
                                    <div class="social-icon-circle telegram-bg">
                                        <i class="fab fa-telegram social-icon"></i>
                                    </div>
                                    <div class="social-count" data-stat-key="social_telegram">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'telegram_value', '0') }}</div>
                                    <div class="social-name">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'telegram_label', 'TELEGRAM') }}</div>
                                </div>
                                <div class="social-icon-item">
                                    <div class="social-icon-circle instagram-bg">
                                        <i class="fab fa-instagram social-icon"></i>
                                    </div>
                                    <div class="social-count" data-stat-key="social_instagram">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'instagram_value', '0') }}</div>
                                    <div class="social-name">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'instagram_label', 'Instagram') }}</div>
                                </div>
                                <div class="social-icon-item">
                                    <div class="social-icon-circle youtube-bg">
                                        <i class="fab fa-youtube social-icon"></i>
                                    </div>
                                    <div class="social-count" data-stat-key="social_youtube">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'youtube_value', '0') }}</div>
                                    <div class="social-name">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'youtube_label', 'YOUTUBE') }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="social-center-block">
                            <h3 class="analytics-title">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'social_distribution_title', 'Распределение подписчиков по соцсетям') }}</h3>
                            <div class="donut-chart-container events-donut-chart">
                                <div class="datalabels-container">
                                    <canvas id="socialDonutChart"></canvas>
                                </div>
                            </div>
                            <div class="social-legend">
                                <div class="legend-item">
                                    <div class="legend-color" style="background: #3B82F6;"></div>
                                    <span class="legend-text">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'telegram_label', 'TELEGRAM') }}</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color" style="background: #9333EA;"></div>
                                    <span class="legend-text">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'instagram_label', 'Instagram') }}</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color" style="background: #EF4444;"></div>
                                    <span class="legend-text">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'youtube_label', 'YOUTUBE') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="social-right-block">
                            <h3 class="analytics-title">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'portal_title', 'Посещения сайта') }}</h3>
                            <div class="portal-chart-container events-donut-chart">
                                <canvas id="portalChart"></canvas>
                            </div>
                            <div class="portal-stats mt-2">
                                <div class="portal-stat-item">
                                    <div class="text-sm text-gray-600 mb-1 font-medium">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'month_visitors_label', 'За месяц') }}</div>
                                    <div class="text-lg font-bold text-blue-600" id="monthVisitors">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'month_visitors_value', '5') }}</div>
                                    <div class="text-sm text-gray-500">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'visitors_label', 'посетителей') }}</div>
                                </div>
                                <div class="portal-stat-item">
                                    <div class="text-sm text-gray-600 mb-1 font-medium">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'views_label', 'Просмотры') }}</div>
                                    <div class="text-lg font-bold text-green-600" id="monthViews">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'views_value', '9') }}</div>
                                    <div class="text-sm text-gray-500">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'per_month_label', 'за месяц') }}</div>
                                </div>
                                <div class="portal-stat-item">
                                    <div class="text-sm text-gray-600 mb-1 font-medium">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'today_visits_label', 'За сегодня') }}</div>
                                    <div class="text-lg font-bold text-purple-600" id="todayVisits">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'today_visits_value', '5') }}</div>
                                    <div class="text-sm text-gray-500">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'visitors_label', 'посетителей') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid ideology-blocks-row">
                    <div class="bg-white rounded-lg border border-gray-300 block-with-icon">
                        <div class="block-icon-text-container">
                            <i class="fas fa-dumbbell block-icon text-green-600 text-3xl"></i>
                            <div class="block-text text-lg font-bold">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'sports_sections_label', 'Спортивные секции колледжа') }}</div>
                        </div>
                        <div class="block-number text-green-600 mt-4" data-stat-key="ideology_sports_sections">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'sports_sections_value', '0') }}</div>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-300 block-with-icon">
                        <div class="block-icon-text-container">
                            <i class="fas fa-running block-icon text-blue-600 text-3xl"></i>
                            <div class="block-text text-lg font-bold">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'sports_students_label', 'Студенты в спортивных секциях') }}</div>
                        </div>
                        <div class="block-number text-blue-600 mt-4" data-stat-key="ideology_sports_students_total">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'sports_students_value', '0') }}</div>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-300 block-with-icon">
                        <div class="block-icon-text-container">
                            <i class="fas fa-trophy block-icon text-yellow-600 text-3xl"></i>
                            <div class="block-text text-lg font-bold">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'winners_label', 'Призеры городских, областных и республиканских соревнований и спортивных олимпиад среди студентов') }}</div>
                        </div>
                        <div class="block-number text-yellow-600 mt-4" data-stat-key="ideology_total_winners">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'winners_value', '0') }}</div>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-300 block-with-icon">
                        <div class="block-icon-text-container">
                            <i class="fas fa-building block-icon text-purple-600 text-3xl"></i>
                            <div class="block-text text-lg font-bold">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'dormitory_label', 'Студенты в общежитии колледжа') }}</div>
                        </div>
                        <div class="block-number text-purple-600 mt-4" data-stat-key="ideology_dormitory_students">{{ \App\Models\PageSection::getValue('dashboard', 'ideology', 'dormitory_value', '0') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'services'" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-x-full"
             x-transition:enter-end="opacity-100 transform translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-x-0"
             x-transition:leave-end="opacity-0 transform -translate-x-full"
             class="h-full absolute inset-0 p-2 overflow-hidden">
            
            <div class="h-full overflow-hidden flex flex-col">
                <div class="grid admin-top-row mb-2">
                    <div class="bg-white rounded-lg border border-gray-300 block-with-icon">
                        <div class="block-icon-text-container">
                            <i class="fas fa-user-clock block-icon text-blue-600 text-3xl"></i>
                            <div class="block-text text-lg font-bold">{{ \App\Models\PageSection::getValue('dashboard', 'admin', 'average_age_label', 'Средний возраст ИПР') }}</div>
                        </div>
                        <div class="block-number text-blue-600 mt-4" data-stat-key="admin_average_age">{{ \App\Models\PageSection::getValue('dashboard', 'admin', 'average_age_value', '0') }}</div>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-300 block-with-icon">
                        <div class="block-icon-text-container">
                            <i class="fas fa-book block-icon text-purple-600 text-3xl"></i>
                            <div class="block-text text-lg font-bold">{{ \App\Models\PageSection::getValue('dashboard', 'admin', 'library_label', 'Фонд электронной библиотеки') }}</div>
                        </div>
                        <div class="block-number text-purple-600 mt-4" data-stat-key="admin_digital_library">{{ \App\Models\PageSection::getValue('dashboard', 'admin', 'library_value', '0') }}</div>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-300 block-with-icon">
                        <div class="block-icon-text-container">
                            <i class="fas fa-chart-line block-icon text-green-600 text-3xl"></i>
                            <div class="block-text text-lg font-bold">{{ \App\Models\PageSection::getValue('dashboard', 'admin', 'portal_visits_label', 'Посещения сайта за сегодня') }}</div>
                        </div>
                        <div class="block-number text-green-600 mt-4" data-stat-key="admin_portal_visits">{{ \App\Models\PageSection::getValue('dashboard', 'admin', 'portal_visits_value', '0') }}</div>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-300 block-with-icon">
                        <div class="block-icon-text-container">
                            <i class="fas fa-comments block-icon text-orange-600 text-3xl"></i>
                            <div class="block-text text-lg font-bold">{{ \App\Models\PageSection::getValue('dashboard', 'admin', 'cos_appeals_label', 'Обращений в ЦОС за месяц') }}</div>
                        </div>
                        <div class="block-number text-orange-600 mt-4" data-stat-key="admin_cos_appeals">{{ \App\Models\PageSection::getValue('dashboard', 'admin', 'cos_appeals_value', '0') }}</div>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-300 block-with-icon">
                        <div class="block-icon-text-container">
                            <i class="fas fa-comments block-icon text-pink-600 text-3xl"></i>
                            <div class="block-text text-lg font-bold">{{ \App\Models\PageSection::getValue('dashboard', 'admin', 'blog_appeals_label', 'Обращений в блог руководителя') }}</div>
                        </div>
                        <div class="block-number text-pink-600 mt-4" data-stat-key="admin_blog_appeals">{{ \App\Models\PageSection::getValue('dashboard', 'admin', 'blog_appeals_value', '0') }}</div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-300 admin-bottom-row flex flex-col">
                    <div class="flex items-center gap-3 mb-3 p-3">
                        <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center">
                            <i class="fas fa-users text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ \App\Models\PageSection::getValue('dashboard', 'admin', 'teachers_title', 'Количество педагогов предметных и цикловых комиссий колледжа') }}</h3>
                        </div>
                    </div>
                    
                    <div class="flex-1 min-h-0 flex flex-col p-3 pt-0">
                        <div class="chart-container flex-1 mb-8 relative" style="height: 220px;">
                            <canvas id="teachersChart"></canvas>
                            <div class="chart-text-values-bottom" id="teachersChartNumbers">
                                <div class="chart-text-value-bottom" id="teachersNumber1" style="transform: translateX(20px);">{{ \App\Models\PageSection::getValue('dashboard', 'admin', 'teachers_transport_value', '15') }}</div>
                                <div class="chart-text-value-bottom" id="teachersNumber2" style="transform: translateX(20px);">{{ \App\Models\PageSection::getValue('dashboard', 'admin', 'teachers_computers_value', '7') }}</div>
                                <div class="chart-text-value-bottom" id="teachersNumber3" style="transform: translateX(15px);">{{ \App\Models\PageSection::getValue('dashboard', 'admin', 'teachers_automation_value', '17') }}</div>
                                <div class="chart-text-value-bottom" id="teachersNumber4" style="transform: translateX(10px);">{{ \App\Models\PageSection::getValue('dashboard', 'admin', 'teachers_sports_value', '5') }}</div>
                                <div class="chart-text-value-bottom" id="teachersNumber5" style="transform: translateX(10px);">{{ \App\Models\PageSection::getValue('dashboard', 'admin', 'teachers_general_value', '13') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'tech'" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-x-full"
             x-transition:enter-end="opacity-100 transform translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-x-0"
             x-transition:leave-end="opacity-0 transform -translate-x-full"
             class="h-full absolute inset-0 p-2 overflow-hidden">
            
            <div class="it-cluster-grid overflow-hidden">
                <div class="it-cluster-top-row min-h-0">
                    <div class="bg-white rounded-lg tight-card border border-gray-300 flex-1 min-h-0 flex flex-col">
                        <h3 class="chart-title-small text-gray-800 mb-1 flex items-center gap-1">
                            <i class="fas fa-book text-purple-600 text-xs"></i>
                            {{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'digital_resources_title', 'Электронные учебные ресурсы') }}
                        </h3>
                        
                        <div class="chart-container flex-1 min-h-0 mb-2 relative big-donut-chart">
                            <div class="datalabels-container">
                                <canvas id="digitalResourcesChart"></canvas>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-2 text-base mt-2 flex-shrink-0">
                            <div class="text-center">
                                <div class="text-lg font-bold text-blue-600" data-stat-key="tech_video_lectures">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'video_lectures_value', '0') }}</div>
                                <div class="text-gray-600 font-bold">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'video_lectures_label', 'Видеолекции') }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-yellow-600" data-stat-key="tech_educational_publications">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'educational_publications_value', '0') }}</div>
                                <div class="text-gray-600 font-bold">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'educational_publications_label', 'Учебные издания') }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-gray-600" data-stat-key="tech_mobile_resources">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'mobile_resources_value', '0') }}</div>
                                <div class="text-gray-600 font-bold">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'mobile_resources_label', 'Мобильные ресурсы') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg tight-card border border-gray-300 flex-1 min-h-0" style="padding: 10px;">
                        <div class="flex items-center gap-2 mb-3 pb-3 border-b border-gray-300">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-blue-700 flex items-center justify-center flex-shrink=0">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="chart-title-small text-gray-800 flex items-center gap-1">
                                    {{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'personal_accounts_title', 'Личные кабинеты') }}
                                </h3>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center">
                                        <i class="fas fa-user-graduate text-green-600 text-xs"></i>
                                    </div>
                                    <div>
                                        <div class="text-lg font-medium text-gray-700">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'students_label', 'Студенты') }}</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-green-600" data-stat-key="it_accounts_students">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'students_value', '0') }}</div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-2 pb-3 border-b border-gray-200">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center">
                                        <i class="fas fa-chalkboard-teacher text-red-600 text-xs"></i>
                                    </div>
                                    <div>
                                        <div class="text-lg font-medium text-gray-700">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'teachers_label', 'Преподаватели') }}</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-red-600" data-stat-key="it_accounts_teachers">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'teachers_value', '0') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="it-cluster-bottom-row min-h-0">
                    <div class="bg-white rounded-lg tight-card border border-gray-300 flex flex-col min-h-0">
                        <h3 class="chart-title-small text-gray-800 mb-3 flex items-center gap-1">
                            <i class="fas fa-building text-teal-600 text-xs"></i>
                            {{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'building_title', 'Люди в здании колледжа по данным СКУД') }}
                        </h3>
                        
                        <div class="flex-1 min-h-0 flex">
                            <div class="building-content-wrapper">
                                <div class="flex flex-col justify-between flex-1">
                                    <div class="text-lg text-gray-700 font-bold mb-2">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'total_in_building_label', 'Всего в здании:') }}</div>
                                    <div class="text-3xl font-bold text-teal-600 mb-3" data-stat-key="tech_building_total">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'total_in_building_value', '0') }}</div>
                                    
                                    <div class="building-stats-grid">
                                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                            <div class="flex items-center gap-2">
                                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                                <span class="text-lg font-bold text-gray-700">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'students_label', 'Студенты') }}</span>
                                            </div>
                                            <div class="text-2xl font-bold text-green-600" data-stat-key="tech_building_students">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'building_students_value', '0') }}</div>
                                        </div>
                                        
                                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                            <div class="flex items-center gap-2">
                                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                                <span class="text-lg font-bold text-gray-700">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'teachers_label', 'Преподаватели') }}</span>
                                            </div>
                                            <div class="text-2xl font-bold text-red-600" data-stat-key="tech_building_teachers">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'building_teachers_value', '0') }}</div>
                                        </div>
                                        
                                        <div class="flex items-center justify-between py-2">
                                            <div class="flex items-center gap-2">
                                                <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                                                <span class="text-lg font-bold text-gray-700">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'staff_label', 'Сотрудники') }}</span>
                                            </div>
                                            <div class="text-2xl font-bold text-purple-600" data-stat-key="tech_building_staff">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'building_staff_value', '0') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="building-chart-container">
                                <div class="datalabels-container">
                                    <canvas id="buildingPeopleChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="it-cluster-vertical-container">
                        <div class="vertical-infrastructure-list">
                            <div class="vertical-infrastructure-card">
                                <div class="infrastructure-icon-text-wrapper">
                                    <div class="infrastructure-icon-circle purple-bg">
                                        <i class="fas fa-desktop infrastructure-icon"></i>
                                    </div>
                                    <div class="infrastructure-text">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'modern_it_label', 'Доля современной IT-техники') }}</div>
                                </div>
                                <div class="infrastructure-value purple">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'modern_it_value', '70') }}<span class="infrastructure-unit">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'percent_label', '%') }}</span></div>
                            </div>

                            <div class="vertical-infrastructure-card">
                                <div class="infrastructure-icon-text-wrapper">
                                    <div class="infrastructure-icon-circle green-bg">
                                        <i class="fas fa-tv infrastructure-icon"></i>
                                    </div>
                                    <div class="infrastructure-text">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'pc_label', 'ПК в учебном процессе') }}</div>
                                </div>
                                <div class="infrastructure-value green">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'pc_value', '265') }}</div>
                            </div>

                            <div class="vertical-infrastructure-card">
                                <div class="infrastructure-icon-text-wrapper">
                                    <div class="infrastructure-icon-circle green-bg">
                                        <i class="fas fa-desktop infrastructure-icon"></i>
                                    </div>
                                    <div class="infrastructure-text">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'computer_classes_label', 'Компьютерные классы') }}</div>
                                </div>
                                <div class="infrastructure-value green">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'computer_classes_value', '19') }}</div>
                            </div>

                            <div class="vertical-infrastructure-card">
                                <div class="infrastructure-icon-text-wrapper">
                                    <div class="infrastructure-icon-circle blue-bg">
                                        <i class="fas fa-wifi infrastructure-icon"></i>
                                    </div>
                                    <div class="infrastructure-text">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'wifi_points_label', 'WiFi точки') }}</div>
                                </div>
                                <div class="infrastructure-value blue">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'wifi_points_value', '73') }}</div>
                            </div>

                            <div class="vertical-infrastructure-card">
                                <div class="infrastructure-icon-text-wrapper">
                                    <div class="infrastructure-icon-circle blue-bg">
                                        <i class="fas fa-tachometer-alt infrastructure-icon"></i>
                                    </div>
                                    <div class="infrastructure-text">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'internet_speed_label', 'Скорость интернета') }}</div>
                                </div>
                                <div class="infrastructure-value blue">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'internet_speed_value', '1') }}<span class="infrastructure-unit">{{ \App\Models\PageSection::getValue('dashboard', 'it_cluster', 'gbit_label', 'Gbit/s') }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="footer-container">
        <div class="dashboard-footer">
            <div class="footer-left">
            </div>
            <div class="footer-right">
                    <div class="weather-widget-container">
                        @livewire('weather-widget', [], key('weather-widget'))
                    </div>
            </div>
        </div>
    </div>
</div>

<script>
    let chartInstances = {};
    let chartsInitialized = false;
    let currentYear = new Date().getFullYear();
    let monthlyData = {};
    let teachersDataCache = [15, 7, 17, 5, 13];
    let lastTeachersData = null;

    const API_BASE = '/api/dashboard';
    const VISITS_API_BASE = '/portal-visits';
    const UPDATE_INTERVAL = 30000;

    const translations = {
        months: {
            'январь': '{{ \App\Models\PageSection::getValue("dashboard", "months", "january", "Январь") }}',
            'февраль': '{{ \App\Models\PageSection::getValue("dashboard", "months", "february", "Февраль") }}',
            'март': '{{ \App\Models\PageSection::getValue("dashboard", "months", "march", "Март") }}',
            'апрель': '{{ \App\Models\PageSection::getValue("dashboard", "months", "april", "Апрель") }}',
            'май': '{{ \App\Models\PageSection::getValue("dashboard", "months", "may", "Май") }}',
            'июнь': '{{ \App\Models\PageSection::getValue("dashboard", "months", "june", "Июнь") }}',
            'июль': '{{ \App\Models\PageSection::getValue("dashboard", "months", "july", "Июль") }}',
            'август': '{{ \App\Models\PageSection::getValue("dashboard", "months", "august", "Август") }}',
            'сентябрь': '{{ \App\Models\PageSection::getValue("dashboard", "months", "september", "Сентябрь") }}',
            'октябрь': '{{ \App\Models\PageSection::getValue("dashboard", "months", "october", "Октябрь") }}',
            'ноябрь': '{{ \App\Models\PageSection::getValue("dashboard", "months", "november", "Ноябрь") }}',
            'декабрь': '{{ \App\Models\PageSection::getValue("dashboard", "months", "december", "Декабрь") }}'
        },
        departments: {
            'ОП, АТ и С': '{{ \App\Models\PageSection::getValue("dashboard", "academic", "department_op", "ОП, АТ и С") }}',
            'ВХ и ПХ, АД': '{{ \App\Models\PageSection::getValue("dashboard", "academic", "department_vh", "ВХ и ПХ, АД") }}',
            'IT-отделение': '{{ \App\Models\PageSection::getValue("dashboard", "academic", "department_it", "IT-отделение") }}',
            'ОЗО': '{{ \App\Models\PageSection::getValue("dashboard", "academic", "department_ozo", "ОЗО") }}'
        },
        levels: {
            'Рабочая квалификация': '{{ \App\Models\PageSection::getValue("dashboard", "academic", "work_qualification_label", "Рабочая квалификация") }}',
            'Специалист среднего звена': '{{ \App\Models\PageSection::getValue("dashboard", "academic", "mid_specialist_label", "Специалист среднего звена") }}',
            'Прикладной бакалавр': '{{ \App\Models\PageSection::getValue("dashboard", "academic", "applied_bachelor_label", "Прикладной бакалавр") }}'
        },
        contingent: {
            'ГЗ': '{{ \App\Models\PageSection::getValue("dashboard", "academic", "gz_label", "ГЗ") }}',
            'ЦГЗ': '{{ \App\Models\PageSection::getValue("dashboard", "academic", "cgz_label", "ЦГЗ") }}',
            'Платно': '{{ \App\Models\PageSection::getValue("dashboard", "academic", "paid_label", "Платно") }}',
            'ГЗ+ЦГЗ': '{{ \App\Models\PageSection::getValue("dashboard", "academic", "gz_cgz_label", "ГЗ+ЦГЗ") }}'
        },
        employment: {
            'Трудоустроены': '{{ \App\Models\PageSection::getValue("dashboard", "academic", "employed_label", "Трудоустроены") }}',
            'Учёба / декрет / армия': '{{ \App\Models\PageSection::getValue("dashboard", "academic", "studying_label", "Учёба / декрет / армия") }}',
            'Не трудоустроены': '{{ \App\Models\PageSection::getValue("dashboard", "academic", "unemployed_label", "Не трудоустроены") }}'
        },
        ipr: {
            'Педагог-исследователь': '{{ \App\Models\PageSection::getValue("dashboard", "academic", "researcher_label", "Педагог-исследователь") }}',
            'Педагог-эксперт': '{{ \App\Models\PageSection::getValue("dashboard", "academic", "expert_label", "Педагог-эксперт") }}',
            'Педагог-модератор': '{{ \App\Models\PageSection::getValue("dashboard", "academic", "moderator_label", "Педагог-модератор") }}'
        },
        social: {
            'TELEGRAM': '{{ \App\Models\PageSection::getValue("dashboard", "ideology", "telegram_label", "TELEGRAM") }}',
            'Instagram': '{{ \App\Models\PageSection::getValue("dashboard", "ideology", "instagram_label", "Instagram") }}',
            'YOUTUBE': '{{ \App\Models\PageSection::getValue("dashboard", "ideology", "youtube_label", "YOUTUBE") }}'
        },
        teachers: {
            'Транспорт': '{{ \App\Models\PageSection::getValue("dashboard", "admin", "teachers_transport_label", "Транспорт") }}',
            'Вычислительная техника': '{{ \App\Models\PageSection::getValue("dashboard", "admin", "teachers_computers_label", "Вычислительная техника") }}',
            'Автоматика и связь': '{{ \App\Models\PageSection::getValue("dashboard", "admin", "teachers_automation_label", "Автоматика и связь") }}',
            'Физическая культура': '{{ \App\Models\PageSection::getValue("dashboard", "admin", "teachers_sports_label", "Физическая культура") }}',
            'Общеобразовательные': '{{ \App\Models\PageSection::getValue("dashboard", "admin", "teachers_general_label", "Общеобразовательные") }}'
        },
        resources: {
            'Видеолекции': '{{ \App\Models\PageSection::getValue("dashboard", "it_cluster", "video_lectures_label", "Видеолекции") }}',
            'Учебные издания': '{{ \App\Models\PageSection::getValue("dashboard", "it_cluster", "educational_publications_label", "Учебные издания") }}',
            'Мобильные': '{{ \App\Models\PageSection::getValue("dashboard", "it_cluster", "mobile_resources_label", "Мобильные ресурсы") }}'
        },
        building: {
            'Студенты': '{{ \App\Models\PageSection::getValue("dashboard", "it_cluster", "students_label", "Студенты") }}',
            'Преподаватели': '{{ \App\Models\PageSection::getValue("dashboard", "it_cluster", "teachers_label", "Преподаватели") }}',
            'Сотрудники': '{{ \App\Models\PageSection::getValue("dashboard", "it_cluster", "staff_label", "Сотрудники") }}'
        }
    };

    function getTranslation(key, defaultValue = '') {
        const keys = key.split('.');
        let value = translations;
        
        for (const k of keys) {
            if (value && value[k] !== undefined) {
                value = value[k];
            } else {
                return defaultValue;
            }
        }
        
        return value || defaultValue;
    }

    function getMonthTranslation(monthName) {
        return getTranslation(`months.${monthName.toLowerCase()}`, monthName);
    }

    async function fetchPortalVisitsData() {
        try {
            const now = new Date();
            const cacheKey = `portal_visits_${now.getFullYear()}_${now.getMonth()}_${now.getDate()}_${now.getHours()}`;
            const cachedData = localStorage.getItem(cacheKey);
            
            if (cachedData) {
                const data = JSON.parse(cachedData);
                const cacheAge = now.getTime() - data.timestamp;
                
                if (cacheAge < 30000) {
                    return data;
                }
            }
            
            const response = await fetch(`${VISITS_API_BASE}/all`);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            
            if (!result.success) {
                throw new Error('API returned error');
            }
            
            const data = {
                todayVisits: result.today?.todayVisits || result.today?.visitors || 0,
                monthVisitors: result.month?.monthVisitors || result.month?.visitors || 0,
                monthVisits: result.month?.monthVisits || result.month?.visits || 0,
                monthViews: result.month?.monthViews || result.month?.views || 0,
                timestamp: now.getTime()
            };
            
            localStorage.setItem(cacheKey, JSON.stringify(data));
            
            return data;
            
        } catch (error) {
            console.error('Failed to fetch portal visits data:', error);
            
            const fallbackCache = localStorage.getItem('portal_visits_fallback');
            if (fallbackCache) {
                return JSON.parse(fallbackCache);
            }
            
            return {
                todayVisits: 0,
                monthVisitors: 0,
                monthVisits: 0,
                monthViews: 0,
                timestamp: new Date().getTime()
            };
        }
    }

    async function fetchStatistics(category = null) {
        try {
            let url;
            if (category) {
                url = `${API_BASE}/category/${category}`;
            } else {
                url = `${API_BASE}/data`;
            }
            
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            
            if (Array.isArray(data)) {
                return data;
            } else if (data.statistics && Array.isArray(data.statistics)) {
                return data.statistics;
            } else if (data.success && data.statistics) {
                return data.statistics;
            } else if (data.data && Array.isArray(data.data)) {
                return data.data;
            }
            
            return [];
        } catch (error) {
            console.error('Failed to fetch statistics:', error);
            return [];
        }
    }

    function getStatValue(statistics, key, defaultValue = null) {
        if (!statistics || !Array.isArray(statistics)) {
            return defaultValue;
        }
        
        const stat = statistics.find(s => s.key === key);
        return stat ? (stat.value !== undefined ? stat.value : stat.formatted_value) : defaultValue;
    }

    async function updatePortalDataFromDatabase() {
        try {
            const portalData = await fetchPortalVisitsData();
            
            updatePortalStats(portalData.monthVisitors, portalData.monthViews, portalData.todayVisits);
            
            if (chartInstances['portalChart']) {
                const chart = chartInstances['portalChart'];
                const currentMonthIndex = 11;
                
                chart.data.datasets[0].data[currentMonthIndex] = portalData.monthVisitors;
                chart.data.datasets[1].data[currentMonthIndex] = portalData.monthViews;
                chart.update();
                
                const now = new Date();
                const currentMonth = now.getMonth();
                const currentYear = now.getFullYear();
                const dataKey = `portal_chart_data_${currentYear}_${currentMonth}`;
                
                const existingData = JSON.parse(localStorage.getItem(dataKey) || '{"visitors":[],"views":[]}');
                existingData.visitors[currentMonthIndex] = portalData.monthVisitors;
                existingData.views[currentMonthIndex] = portalData.monthViews;
                
                localStorage.setItem(dataKey, JSON.stringify({
                    ...existingData,
                    lastUpdate: now.getTime()
                }));
            }
            
            const adminPortalVisits = document.querySelector('[data-stat-key="admin_portal_visits"]');
            if (adminPortalVisits) {
                adminPortalVisits.textContent = portalData.todayVisits;
            }
            
            saveMonthlyData(portalData.monthVisitors, portalData.monthViews);
            
        } catch (error) {
            console.error('Failed to update portal data from database:', error);
        }
    }

    function updatePortalStats(monthVisitors, monthViews, todayVisits) {
        const monthVisitorsElement = document.getElementById('monthVisitors');
        const monthViewsElement = document.getElementById('monthViews');
        const todayVisitsElement = document.getElementById('todayVisits');
        
        if (monthVisitorsElement) monthVisitorsElement.textContent = monthVisitors;
        if (monthViewsElement) monthViewsElement.textContent = monthViews;
        if (todayVisitsElement) todayVisitsElement.textContent = todayVisits;
        
        const adminPortalVisits = document.querySelector('[data-stat-key="admin_portal_visits"]');
        if (adminPortalVisits) {
            adminPortalVisits.textContent = todayVisits;
        }
    }

    function saveMonthlyData(visitors, views) {
        const now = new Date();
        const month = now.getMonth();
        const year = now.getFullYear();
        
        const key = `${year}-${month}`;
        
        monthlyData[key] = {
            visitors: visitors,
            views: views,
            timestamp: now.getTime()
        };
        
        localStorage.setItem('portalMonthlyData', JSON.stringify(monthlyData));
        
        localStorage.setItem('portal_visits_fallback', JSON.stringify({
            todayVisits: visitors,
            monthVisitors: visitors,
            monthVisits: visitors,
            monthViews: views,
            timestamp: now.getTime()
        }));
    }

    function loadMonthlyData() {
        const data = localStorage.getItem('portalMonthlyData');
        if (data) {
            monthlyData = JSON.parse(data);
            return monthlyData;
        }
        return {};
    }

    function initAllCharts() {
        if (chartsInitialized) return;
        
        Chart.register(ChartDataLabels);
        Chart.defaults.font.size = 14;
        Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
        Chart.defaults.font.weight = 'bold';
        
        const createOrUpdateDonutChart = (ctx, chartId, data, labels, colors, segmentLabels, showLegend = true, fontSize = 22, cutout = '60%') => {
            const total = data.reduce((a, b) => a + b, 0);
            const percentages = data.map(value => total > 0 ? Math.round((value / total) * 100) : 0);
            
            const translatedLabels = labels.map(label => getTranslation(label, label));
            
            if (chartInstances[chartId]) {
                chartInstances[chartId].data.datasets[0].data = data;
                chartInstances[chartId].data.labels = translatedLabels;
                chartInstances[chartId].update();
                return chartInstances[chartId];
            }
            
            const chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: translatedLabels,
                    datasets: [{
                        data: data,
                        backgroundColor: colors,
                        borderWidth: 3,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            display: showLegend,
                            position: 'bottom',
                            labels: { 
                                color: '#374151', 
                                font: { size: 12, weight: 'bold' }, 
                                padding: 8,
                                boxWidth: 12,
                                boxHeight: 12
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const percentage = percentages[context.dataIndex];
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        },
                        datalabels: {
                            display: true,
                            color: '#ffffff',
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            formatter: function(value, context) {
                                return percentages[context.dataIndex] + '%';
                            },
                            backgroundColor: function(context) {
                                return 'rgba(0, 0, 0, 0.7)';
                            },
                            borderRadius: 4,
                            padding: {
                                top: 4,
                                bottom: 4,
                                left: 6,
                                right: 6
                            },
                            textAlign: 'center',
                            textStrokeColor: 'rgba(0, 0, 0, 0.8)',
                            textStrokeWidth: 1,
                            textShadowBlur: 2,
                            textShadowColor: 'rgba(0, 0, 0, 0.8)',
                            clip: false,
                            align: 'center',
                            offset: 0,
                            anchor: 'center'
                        }
                    },
                    cutout: cutout,
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 1000,
                        easing: 'easeOutQuart'
                    }
                },
                plugins: [ChartDataLabels]
            });
            
            chartInstances[chartId] = chart;
            return chart;
        };

        const createNestedDonutChartWithPercentages = (ctx, chartId, gzValue, cgzValue, paidValue, title) => {
            const total = gzValue + cgzValue + paidValue;
            const gzPercentage = total > 0 ? Math.round((gzValue / total) * 100) : 0;
            const cgzPercentage = total > 0 ? Math.round((cgzValue / total) * 100) : 0;
            const paidPercentage = total > 0 ? Math.round((paidValue / total) * 100) : 0;
            
            const totalGzCgz = gzValue + cgzValue;
            const gzCgzPercentage = total > 0 ? Math.round((totalGzCgz / total) * 100) : 0;
            
            const gzLabel = getTranslation('contingent.ГЗ', 'ГЗ');
            const cgzLabel = getTranslation('contingent.ЦГЗ', 'ЦГЗ');
            const gzCgzLabel = getTranslation('contingent.ГЗ+ЦГЗ', 'ГЗ+ЦГЗ');
            const paidLabel = getTranslation('contingent.Платно', 'Платно');
            
            if (chartInstances[chartId]) {
                chartInstances[chartId].data.datasets[0].data = [totalGzCgz, paidValue];
                chartInstances[chartId].data.datasets[1].data = [gzValue, cgzValue];
                chartInstances[chartId].update();
                return chartInstances[chartId];
            }
            
            const chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [gzLabel, cgzLabel],
                    datasets: [
                        {
                            data: [totalGzCgz, paidValue],
                            backgroundColor: ['#3B82F6', '#F97316'],
                            borderWidth: 4,
                            borderColor: '#fff',
                            weight: 2
                        },
                        {
                            data: [gzValue, cgzValue],
                            backgroundColor: ['#8B5CF6', '#10B981'],
                            borderWidth: 3,
                            borderColor: '#fff',
                            weight: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw || 0;
                                    
                                    if (context.datasetIndex === 0) {
                                        if (context.dataIndex === 0) {
                                            return `${gzCgzLabel}: ${value} (${gzCgzPercentage}%)`;
                                        } else {
                                            return `${paidLabel}: ${value} (${paidPercentage}%)`;
                                        }
                                    } else {
                                        if (context.dataIndex === 0) {
                                            return `${gzLabel}: ${value} (${gzPercentage}%)`;
                                        } else {
                                            return `${cgzLabel}: ${value} (${cgzPercentage}%)`;
                                        }
                                    }
                                }
                            }
                        },
                        datalabels: {
                            display: true,
                            color: '#ffffff',
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            formatter: function(value, context) {
                                if (context.datasetIndex === 0) {
                                    if (context.dataIndex === 0) {
                                        return gzCgzPercentage + '%';
                                    } else {
                                        return paidPercentage + '%';
                                    }
                                } else {
                                    if (context.dataIndex === 0) {
                                        return gzPercentage + '%';
                                    } else {
                                        return cgzPercentage + '%';
                                    }
                                }
                            },
                            backgroundColor: function(context) {
                                return 'rgba(0, 0, 0, 0.7)';
                            },
                            borderRadius: 4,
                            padding: {
                                top: 4,
                                bottom: 4,
                                left: 6,
                                right: 6
                            },
                            textAlign: 'center',
                            textStrokeColor: 'rgba(0, 0, 0, 0.8)',
                            textStrokeWidth: 1,
                            textShadowBlur: 2,
                            textShadowColor: 'rgba(0, 0, 0, 0.8)',
                            clip: false,
                            align: 'center',
                            offset: 0,
                            anchor: 'center'
                        }
                    },
                    cutout: '55%',
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 1000,
                        easing: 'easeOutQuart'
                    }
                },
                plugins: [ChartDataLabels]
            });
            
            chartInstances[chartId] = chart;
            return chart;
        };
        
        const contingentCtx = document.getElementById('contingentChart');
        if (contingentCtx) {
            createNestedDonutChartWithPercentages(contingentCtx, 'contingentChart', 2500, 800, 577);
        }

        const admissionCtx = document.getElementById('admissionChart');
        if (admissionCtx) {
            createNestedDonutChartWithPercentages(admissionCtx, 'admissionChart', 150, 50, 12);
        }

        const employmentCtx = document.getElementById('employmentChart');
        if (employmentCtx) {
            const employedLabel = getTranslation('employment.Трудоустроены', 'Трудоустроены');
            const studyingLabel = getTranslation('employment.Учёба / декрет / армия', 'Учёба / декрет / армия');
            const unemployedLabel = getTranslation('employment.Не трудоустроены', 'Не трудоустроены');
            
            createOrUpdateDonutChart(employmentCtx, 'employmentChart',
                [81, 15, 4], 
                [employedLabel, studyingLabel, unemployedLabel], 
                ['#10B981', '#3B82F6', '#EF4444'],
                ['81%', '15%', '4%'],
                false,
                24,
                '55%'
            );
        }

        const iprQualityCtx = document.getElementById('iprQualityChart');
        if (iprQualityCtx) {
            const researcherLabel = getTranslation('ipr.Педагог-исследователь', 'Педагог-исследователь');
            const expertLabel = getTranslation('ipr.Педагог-эксперт', 'Педагог-эксперт');
            const moderatorLabel = getTranslation('ipr.Педагог-модератор', 'Педагог-модератор');
            
            createOrUpdateDonutChart(iprQualityCtx, 'iprQualityChart',
                [28, 35, 17], 
                [researcherLabel, expertLabel, moderatorLabel], 
                ['#8B5CF6', '#3B82F6', '#6B7280'],
                ['35%', '44%', '21%'],
                false,
                20,
                '55%'
            );
        }

        const departmentsCtx = document.getElementById('departmentsChart');
        if (departmentsCtx) {
            const departmentsData = [
                [1000, 800, 600, 400],
                [700, 600, 300, 200],
                [150, 100, 80, 50]
            ];
            
            const workQualLabel = getTranslation('levels.Рабочая квалификация', 'Рабочая квалификация');
            const midSpecialistLabel = getTranslation('levels.Специалист среднего звена', 'Специалист среднего звена');
            const appliedBachelorLabel = getTranslation('levels.Прикладной бакалавр', 'Прикладной бакалавр');
            
            chartInstances['departmentsChart'] = new Chart(departmentsCtx, {
                type: 'bar',
                data: {
                    labels: ['', '', '', ''],
                    datasets: [
                        {
                            label: workQualLabel,
                            data: departmentsData[0],
                            backgroundColor: '#3B82F6',
                            borderWidth: 0,
                            borderRadius: 2,
                            barThickness: 25
                        },
                        {
                            label: midSpecialistLabel,
                            data: departmentsData[1],
                            backgroundColor: '#10B981',
                            borderWidth: 0,
                            borderRadius: 2,
                            barThickness: 25
                        },
                        {
                            label: appliedBachelorLabel,
                            data: departmentsData[2],
                            backgroundColor: '#FB923C',
                            borderWidth: 0,
                            borderRadius: 2,
                            barThickness: 25
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                title: function(tooltipItems) {
                                    const index = tooltipItems[0].dataIndex;
                                    const departmentKeys = ['ОП, АТ и С', 'ВХ и ПХ, АД', 'IT-отделение', 'ОЗО'];
                                    const departmentKey = departmentKeys[index];
                                    return getTranslation(`departments.${departmentKey}`, departmentKey);
                                },
                                label: function(context) {
                                    const label = context.dataset.label || '';
                                    const value = context.raw || 0;
                                    const total = context.chart.data.datasets.reduce((sum, dataset) => sum + dataset.data[context.dataIndex], 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        },
                        datalabels: {
                            display: true,
                            color: '#ffffff',
                            font: {
                                size: 11,
                                weight: 'bold'
                            },
                            formatter: function(value, context) {
                                if (value === 0) return '';
                                const total = context.chart.data.datasets.reduce((sum, dataset) => sum + dataset.data[context.dataIndex], 0);
                                const percentage = Math.round((value / total) * 100);
                                return percentage + '%';
                            },
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            borderRadius: 3,
                            padding: {
                                top: 2,
                                bottom: 2,
                                left: 4,
                                right: 4
                            },
                            textStrokeColor: 'rgba(0, 0, 0, 0.8)',
                            textStrokeWidth: 1,
                            clip: false
                        }
                    },
                    scales: {
                        x: {
                            stacked: true,
                            ticks: { 
                                color: '#6B7280', 
                                font: { size: 0 },
                                display: false
                            },
                            grid: { display: false }
                        },
                        y: {
                            stacked: true,
                            ticks: { 
                                color: '#6B7280', 
                                font: { size: 11, weight: 'bold' } 
                            },
                            grid: { color: '#E5E7EB' }
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    }
                },
                plugins: [ChartDataLabels]
            });
        }

        const socialDonutCtx = document.getElementById('socialDonutChart');
        if (socialDonutCtx) {
            const telegramLabel = getTranslation('social.TELEGRAM', 'TELEGRAM');
            const instagramLabel = getTranslation('social.Instagram', 'Instagram');
            const youtubeLabel = getTranslation('social.YOUTUBE', 'YOUTUBE');
            
            createOrUpdateDonutChart(socialDonutCtx, 'socialDonutChart',
                [4052, 12646, 1157], 
                [telegramLabel, instagramLabel, youtubeLabel], 
                ['#3B82F6', '#9333EA', '#EF4444'],
                ['23%', '71%', '6%'],
                false,
                18
            );
        }

        createPortalChart();

        const digitalResourcesCtx = document.getElementById('digitalResourcesChart');
        if (digitalResourcesCtx) {
            const videoLabel = getTranslation('resources.Видеолекции', 'Видеолекции');
            const publicationsLabel = getTranslation('resources.Учебные издания', 'Учебные издания');
            const mobileLabel = getTranslation('resources.Мобильные', 'Мобильные');
            
            createOrUpdateDonutChart(digitalResourcesCtx, 'digitalResourcesChart',
                [176, 319, 41], 
                [videoLabel, publicationsLabel, mobileLabel], 
                ['#3B82F6', '#EAB308', '#6B7280'],
                ['33%', '60%', '7%'],
                false,
                18
            );
        }

        const buildingPeopleCtx = document.getElementById('buildingPeopleChart');
        if (buildingPeopleCtx) {
            const studentsLabel = getTranslation('building.Студенты', 'Студенты');
            const teachersLabel = getTranslation('building.Преподаватели', 'Преподаватели');
            const staffLabel = getTranslation('building.Сотрудники', 'Сотрудники');
            
            createOrUpdateDonutChart(buildingPeopleCtx, 'buildingPeopleChart',
                [1934, 341, 100], 
                [studentsLabel, teachersLabel, staffLabel], 
                ['#22C55E', '#EF4444', '#8B5CF6'],
                ['81%', '14%', '5%'],
                false,
                18
            );
        }

        const teachersCtx = document.getElementById('teachersChart');
        if (teachersCtx) {
            const transportLabel = getTranslation('teachers.Транспорт', 'Транспорт');
            const computersLabel = getTranslation('teachers.Вычислительная техника', 'Вычислительная техника');
            const automationLabel = getTranslation('teachers.Автоматика и связь', 'Автоматика и связь');
            const sportsLabel = getTranslation('teachers.Физическая культура', 'Физическая культура');
            const generalLabel = getTranslation('teachers.Общеобразовательные', 'Общеобразовательные');
            
            const teachersLabels = [
                transportLabel,
                computersLabel,
                automationLabel,
                sportsLabel,
                generalLabel
            ];
            
            chartInstances['teachersChart'] = new Chart(teachersCtx, {
                type: 'bar',
                data: {
                    labels: teachersLabels,
                    datasets: [{
                        label: 'Количество педагогов',
                        data: teachersDataCache,
                        backgroundColor: '#3B82F6',
                        borderWidth: 0,
                        borderRadius: 3,
                        barThickness: 25
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                title: function(tooltipItems) {
                                    const index = tooltipItems[0].dataIndex;
                                    return teachersLabels[index];
                                },
                                label: function(context) {
                                    return `Педагогов: ${context.raw}`;
                                }
                            }
                        },
                        datalabels: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            ticks: { 
                                color: '#6B7280', 
                                font: { 
                                    size: 16, 
                                    weight: 'bold',
                                    lineHeight: 1.2
                                },
                                maxRotation: 45,
                                minRotation: 0
                            },
                            grid: { 
                                display: true,
                                color: 'rgba(0, 0, 0, 0.1)',
                                lineWidth: 1,
                                drawBorder: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            max: 20,
                            ticks: { 
                                color: '#6B7280', 
                                font: { size: 14, weight: 'bold' },
                                stepSize: 5
                            },
                            grid: { 
                                color: '#E5E7EB',
                                drawBorder: false
                            }
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    }
                }
            });
            
            updateTeachersChartNumbers(teachersDataCache);
        }
        
        chartsInitialized = true;
    }

    function updateTeachersChartNumbers(data) {
        for (let i = 1; i <= 5; i++) {
            const element = document.getElementById('teachersNumber' + i);
            if (element && data[i-1] !== undefined) {
                element.textContent = data[i-1];
            }
        }
    }

    function createPortalChart() {
        const portalCtx = document.getElementById('portalChart');
        if (!portalCtx) return;

        const getLast12MonthsLabels = () => {
            const now = new Date();
            const currentMonth = now.getMonth();
            const currentYear = now.getFullYear();
            
            const months = ['январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь'];
            const labels = [];
            
            for (let i = 11; i >= 0; i--) {
                let monthIndex = currentMonth - i;
                let year = currentYear;
                
                if (monthIndex < 0) {
                    monthIndex += 12;
                    year--;
                }
                
                const monthName = months[monthIndex];
                const translatedMonth = getMonthTranslation(monthName);
                labels.push(translatedMonth + ' ' + year.toString().substr(2));
            }
            
            return labels;
        };

        const loadPortalChartData = () => {
            const now = new Date();
            const currentMonth = now.getMonth();
            const currentYear = now.getFullYear();
            const dataKey = `portal_chart_data_${currentYear}_${currentMonth}`;
            
            let chartData = localStorage.getItem(dataKey);
            
            if (!chartData) {
                const visitors = Array(12).fill(0);
                const views = Array(12).fill(0);
                
                visitors[11] = 5;
                views[11] = 9;
                
                return { visitors, views };
            }
            
            return JSON.parse(chartData);
        };

        const savePortalChartData = (visitors, views) => {
            const now = new Date();
            const currentMonth = now.getMonth();
            const currentYear = now.getFullYear();
            const dataKey = `portal_chart_data_${currentYear}_${currentMonth}`;
            
            localStorage.setItem(dataKey, JSON.stringify({
                visitors,
                views,
                lastUpdate: now.getTime()
            }));
        };

        const updatePortalChartForNewMonth = () => {
            const now = new Date();
            const lastUpdateKey = 'portal_chart_last_update';
            const lastUpdate = localStorage.getItem(lastUpdateKey);
            
            if (!lastUpdate) {
                localStorage.setItem(lastUpdateKey, now.getMonth().toString());
                return false;
            }
            
            const lastMonth = parseInt(lastUpdate);
            const currentMonth = now.getMonth();
            
            if (lastMonth !== currentMonth) {
                localStorage.setItem(lastUpdateKey, currentMonth.toString());
                return true;
            }
            
            return false;
        };

        const shiftPortalChartData = () => {
            const existingData = loadPortalChartData();
            const visitors = existingData.visitors;
            const views = existingData.views;
            
            for (let i = 0; i < 11; i++) {
                visitors[i] = visitors[i + 1];
                views[i] = views[i + 1];
            }
            
            visitors[11] = 0;
            views[11] = 0;
            
            savePortalChartData(visitors, views);
            return { visitors, views };
        };

        if (updatePortalChartForNewMonth()) {
            shiftPortalChartData();
        }

        const labels = getLast12MonthsLabels();
        const data = loadPortalChartData();
        
        chartInstances['portalChart'] = new Chart(portalCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Посетители',
                        data: data.visitors,
                        backgroundColor: '#3B82F6',
                        borderWidth: 0,
                        borderRadius: 2,
                        barThickness: 8
                    },
                    {
                        label: 'Просмотры',
                        data: data.views,
                        backgroundColor: '#10B981',
                        borderWidth: 0,
                        borderRadius: 2,
                        barThickness: 8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'bottom',
                        labels: { 
                            color: '#374151', 
                            font: { size: 12, weight: 'bold' }, 
                            padding: 8,
                            boxWidth: 12,
                            boxHeight: 12
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.dataset.label || '';
                                const value = context.raw || 0;
                                return `${label}: ${value.toLocaleString('ru-RU')}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { 
                            color: '#6B7280', 
                            font: { size: 10, weight: 'bold' } 
                        },
                        grid: { 
                            display: true,
                            color: '#E5E7EB'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { 
                            color: '#6B7280', 
                            font: { size: 10, weight: 'bold' },
                            callback: function(value) {
                                return value.toLocaleString('ru-RU');
                            }
                        },
                        grid: { 
                            color: '#E5E7EB',
                            drawBorder: false
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                }
            }
        });
    }

    function updateChart(chartId, newData, newLabels, newSegmentLabels) {
        if (chartInstances[chartId]) {
            const chart = chartInstances[chartId];
            chart.data.datasets[0].data = newData;
            
            if (newLabels) {
                const translatedLabels = newLabels.map(label => getTranslation(label, label));
                chart.data.labels = translatedLabels;
            }
            
            chart.update();
        }
    }

    function updateNestedChart(chartId, gzValue, cgzValue, paidValue) {
        if (chartInstances[chartId]) {
            const chart = chartInstances[chartId];
            const totalGzCgz = gzValue + cgzValue;
            chart.data.datasets[0].data = [totalGzCgz, paidValue];
            chart.data.datasets[1].data = [gzValue, cgzValue];
            chart.update();
        }
    }

    function updateBarChart(chartId, newData, newLabels = null) {
        if (chartInstances[chartId]) {
            const chart = chartInstances[chartId];
            
            if (Array.isArray(newData[0])) {
                chart.data.datasets.forEach((dataset, index) => {
                    if (newData[index]) {
                        dataset.data = newData[index];
                    }
                });
            } else {
                chart.data.datasets[0].data = newData;
                lastTeachersData = newData;
            }
            
            if (newLabels) {
                const translatedLabels = newLabels.map(label => {
                    if (chartId === 'teachersChart') {
                        return getTranslation(`teachers.${label}`, label);
                    }
                    return getTranslation(label, label);
                });
                chart.data.labels = translatedLabels;
            }
            
            chart.update();
            
            if (chartId === 'teachersChart') {
                updateTeachersChartNumbers(newData);
            }
        }
    }

    function updateDepartmentsChart(data) {
        if (chartInstances['departmentsChart'] && data && data.length >= 3) {
            const chart = chartInstances['departmentsChart'];
            chart.data.datasets[0].data = data[0];
            chart.data.datasets[1].data = data[1];
            chart.data.datasets[2].data = data[2];
            chart.update();
        }
    }

    function updateElementsWithStats(stats) {
        if (!stats || !Array.isArray(stats)) {
            return;
        }
        
        const departmentsData = getDepartmentsDataFromStats(stats);
        if (departmentsData) {
            updateDepartmentsChart(departmentsData);
        }
        
        const workQualification = parseInt(getStatValue(stats, 'academic_work_qualification')) || 3530;
        const midSpecialist = parseInt(getStatValue(stats, 'academic_mid_specialist')) || 1170;
        const appliedBachelor = parseInt(getStatValue(stats, 'academic_applied_bachelor')) || 177;
        
        const workQualEl = document.querySelector('[data-stat-key="academic_work_qualification"]');
        const midSpecEl = document.querySelector('[data-stat-key="academic_mid_specialist"]');
        const appBachEl = document.querySelector('[data-stat-key="academic_applied_bachelor"]');
        
        if (workQualEl) workQualEl.textContent = workQualification.toLocaleString('ru-RU');
        if (midSpecEl) midSpecEl.textContent = midSpecialist.toLocaleString('ru-RU');
        if (appBachEl) appBachEl.textContent = appliedBachelor.toLocaleString('ru-RU');
        
        const contingentGz = parseInt(getStatValue(stats, 'academic_contingent_gz')) || 2500;
        const contingentCgz = parseInt(getStatValue(stats, 'academic_contingent_cgz')) || 800;
        const contingentPaid = parseInt(getStatValue(stats, 'academic_contingent_paid')) || 577;
        
        updateNestedChart('contingentChart', contingentGz, contingentCgz, contingentPaid);
        
        const admissionGz = parseInt(getStatValue(stats, 'admission_gz')) || 150;
        const admissionCgz = parseInt(getStatValue(stats, 'admission_cgz')) || 50;
        const admissionPaid = parseInt(getStatValue(stats, 'admission_paid')) || 12;
        
        updateNestedChart('admissionChart', admissionGz, admissionCgz, admissionPaid);
        
        const employed = parseInt(getStatValue(stats, 'employment_employed')) || 81;
        const studying = parseInt(getStatValue(stats, 'employment_studying')) || 15;
        const unemployed = parseInt(getStatValue(stats, 'employment_unemployed')) || 4;
        
        const employedLabel = getTranslation('employment.Трудоустроены', 'Трудоустроены');
        const studyingLabel = getTranslation('employment.Учёба / декрет / армия', 'Учёба / декрет / армия');
        const unemployedLabel = getTranslation('employment.Не трудоустроены', 'Не трудоустроены');
        
        updateChart('employmentChart',
            [employed, studying, unemployed],
            [employedLabel, studyingLabel, unemployedLabel]
        );
        
        const masters = parseInt(getStatValue(stats, 'academic_ipr_masters')) || 28;
        const category = parseInt(getStatValue(stats, 'academic_ipr_category')) || 35;
        const basic = parseInt(getStatValue(stats, 'academic_basic_level')) || 17;
        const totalIpr = parseInt(getStatValue(stats, 'academic_total_ipr')) || 80;
        
        const researcherLabel = getTranslation('ipr.Педагог-исследователь', 'Педагог-исследователь');
        const expertLabel = getTranslation('ipr.Педагог-эксперт', 'Педагог-эксперт');
        const moderatorLabel = getTranslation('ipr.Педагог-модератор', 'Педагог-модератор');
        
        updateChart('iprQualityChart',
            [masters, category, basic],
            [researcherLabel, expertLabel, moderatorLabel]
        );
        
        const totalIprEl = document.querySelector('[data-stat-key="academic_total_ipr"]');
        if (totalIprEl) totalIprEl.textContent = totalIpr;
        
        const foreignLanguageTeachers = parseInt(getStatValue(stats, 'academic_foreign_language_teachers')) || 42;
        const foreignTeachersEl = document.querySelector('[data-stat-key="academic_foreign_language_teachers"]');
        if (foreignTeachersEl) foreignTeachersEl.textContent = foreignLanguageTeachers;
        
        const teachersData = [
            parseInt(getStatValue(stats, 'teachers_transport')) || 15,
            parseInt(getStatValue(stats, 'teachers_computers')) || 7,
            parseInt(getStatValue(stats, 'teachers_automation')) || 17,
            parseInt(getStatValue(stats, 'teachers_sports')) || 5,
            parseInt(getStatValue(stats, 'teachers_general')) || 13
        ];
        
        if (chartInstances['teachersChart']) {
            chartInstances['teachersChart'].data.datasets[0].data = teachersData;
            chartInstances['teachersChart'].update();
            updateTeachersChartNumbers(teachersData);
        }
        
        const techBuildingStudents = parseInt(getStatValue(stats, 'tech_building_students')) || 1934;
        const techBuildingTeachers = parseInt(getStatValue(stats, 'tech_building_teachers')) || 341;
        const techBuildingStaff = parseInt(getStatValue(stats, 'tech_building_staff')) || 100;
        const techBuildingTotal = parseInt(getStatValue(stats, 'tech_building_total')) || 2375;
        
        const studentsLabel = getTranslation('building.Студенты', 'Студенты');
        const teachersLabel = getTranslation('building.Преподаватели', 'Преподаватели');
        const staffLabel = getTranslation('building.Сотрудники', 'Сотрудники');
        
        updateChart('buildingPeopleChart',
            [techBuildingStudents, techBuildingTeachers, techBuildingStaff],
            [studentsLabel, teachersLabel, staffLabel]
        );
        
        const buildingStudentsEl = document.querySelector('[data-stat-key="tech_building_students"]');
        const buildingTeachersEl = document.querySelector('[data-stat-key="tech_building_teachers"]');
        const buildingStaffEl = document.querySelector('[data-stat-key="tech_building_staff"]');
        const buildingTotalEl = document.querySelector('[data-stat-key="tech_building_total"]');
        
        if (buildingStudentsEl) buildingStudentsEl.textContent = techBuildingStudents.toLocaleString('ru-RU');
        if (buildingTeachersEl) buildingTeachersEl.textContent = techBuildingTeachers.toLocaleString('ru-RU');
        if (buildingStaffEl) buildingStaffEl.textContent = techBuildingStaff.toLocaleString('ru-RU');
        if (buildingTotalEl) buildingTotalEl.textContent = techBuildingTotal.toLocaleString('ru-RU');
        
        const itAccountsStudents = parseInt(getStatValue(stats, 'it_accounts_students')) || 8596;
        const itAccountsTeachers = parseInt(getStatValue(stats, 'it_accounts_teachers')) || 625;
        
        const studentsAccountsEl = document.querySelector('[data-stat-key="it_accounts_students"]');
        const teachersAccountsEl = document.querySelector('[data-stat-key="it_accounts_teachers"]');
        
        if (studentsAccountsEl) studentsAccountsEl.textContent = itAccountsStudents.toLocaleString('ru-RU');
        if (teachersAccountsEl) teachersAccountsEl.textContent = itAccountsTeachers.toLocaleString('ru-RU');
        
        const techVideoLectures = parseInt(getStatValue(stats, 'tech_video_lectures')) || 176;
        const techEducationalPublications = parseInt(getStatValue(stats, 'tech_educational_publications')) || 319;
        const techMobileResources = parseInt(getStatValue(stats, 'tech_mobile_resources')) || 41;
        
        const videoLabel = getTranslation('resources.Видеолекции', 'Видеолекции');
        const publicationsLabel = getTranslation('resources.Учебные издания', 'Учебные издания');
        const mobileLabel = getTranslation('resources.Мобильные', 'Мобильные');
        
        updateChart('digitalResourcesChart',
            [techVideoLectures, techEducationalPublications, techMobileResources],
            [videoLabel, publicationsLabel, mobileLabel]
        );
        
        const videoLecturesEl = document.querySelector('[data-stat-key="tech_video_lectures"]');
        const publicationsEl = document.querySelector('[data-stat-key="tech_educational_publications"]');
        const mobileEl = document.querySelector('[data-stat-key="tech_mobile_resources"]');
        
        if (videoLecturesEl) videoLecturesEl.textContent = techVideoLectures.toLocaleString('ru-RU');
        if (publicationsEl) publicationsEl.textContent = techEducationalPublications.toLocaleString('ru-RU');
        if (mobileEl) mobileEl.textContent = techMobileResources.toLocaleString('ru-RU');
        
        stats.forEach(stat => {
            const { key, value, formatted_value, formatted_growth } = stat;
            
            const elements = document.querySelectorAll(`[data-stat-key="${key}"]`);
            elements.forEach(el => {
                if (formatted_value !== undefined) {
                    el.textContent = formatted_value;
                } else if (value !== undefined) {
                    el.textContent = value;
                }
            });
            
            if (key === 'admin_portal_visits') {
                const todayVisits = parseInt(value) || 0;
                
                const now = new Date();
                const currentMonth = now.getMonth();
                const data = loadMonthlyData();
                const monthKey = `${now.getFullYear()}-${currentMonth}`;
                
                let monthVisitors = todayVisits;
                let monthViews = todayVisits * 2;
                
                if (data[monthKey]) {
                    monthVisitors = data[monthKey].visitors;
                    monthViews = data[monthKey].views;
                }
                
                updatePortalStats(monthVisitors, monthViews, todayVisits);
                
                if (chartInstances['portalChart']) {
                    const chart = chartInstances['portalChart'];
                    const currentMonthIndex = 11;
                    
                    chart.data.datasets[0].data[currentMonthIndex] = monthVisitors;
                    chart.data.datasets[1].data[currentMonthIndex] = monthViews;
                    chart.update();
                }
            }
        });
    }

    function getDepartmentsDataFromStats(stats) {
        const departmentKeys = [
            ['departments_work_qualification_op', 'departments_work_qualification_vh', 'departments_work_qualification_it', 'departments_work_qualification_ozo'],
            ['departments_mid_specialist_op', 'departments_mid_specialist_vh', 'departments_mid_specialist_it', 'departments_mid_specialist_ozo'],
            ['departments_applied_bachelor_op', 'departments_applied_bachelor_vh', 'departments_applied_bachelor_it', 'departments_applied_bachelor_ozo']
        ];
        
        const departmentsData = [];
        
        for (let i = 0; i < departmentKeys.length; i++) {
            const levelData = [];
            for (let j = 0; j < departmentKeys[i].length; j++) {
                const value = parseInt(getStatValue(stats, departmentKeys[i][j], 0));
                levelData.push(value);
            }
            departmentsData.push(levelData);
        }
        
        return departmentsData;
    }

    function updateSocialCounts() {
        const telegramEl = document.querySelector('[data-stat-key="social_telegram"]');
        const instagramEl = document.querySelector('[data-stat-key="social_instagram"]');
        const youtubeEl = document.querySelector('[data-stat-key="social_youtube"]');
        
        if (telegramEl) telegramEl.textContent = '4 052';
        if (instagramEl) instagramEl.textContent = '12 646';
        if (youtubeEl) youtubeEl.textContent = '1 157';
        
        const socialTotal = 4052 + 12646 + 1157;
        const telegramPercent = Math.round((4052 / socialTotal) * 100);
        const instagramPercent = Math.round((12646 / socialTotal) * 100);
        const youtubePercent = Math.round((1157 / socialTotal) * 100);
        
        const telegramLabel = getTranslation('social.TELEGRAM', 'TELEGRAM');
        const instagramLabel = getTranslation('social.Instagram', 'Instagram');
        const youtubeLabel = getTranslation('social.YOUTUBE', 'YOUTUBE');
        
        updateChart('socialDonutChart',
            [4052, 12646, 1157],
            [telegramLabel, instagramLabel, youtubeLabel]
        );
    }

    function dashboard() {
        return {
            activeTab: 'academic',
            currentLang: '{{ app()->getLocale() }}',
            tabs: ['academic', 'events', 'services', 'tech'],
            statistics: {
                academic: [],
                events: [],
                services: [],
                tech: []
            },
            
            async init() {
                this.updateClock();
                setInterval(() => this.updateClock(), 1000);
                
                monthlyData = loadMonthlyData();
                
                setTimeout(() => {
                    initAllCharts();
                }, 100);
                
                await this.loadAllStatistics();
                
                await updatePortalDataFromDatabase();
                
                setInterval(() => this.loadAllStatistics(), UPDATE_INTERVAL);
                setInterval(() => updatePortalDataFromDatabase(), UPDATE_INTERVAL);
                
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowLeft') this.previousTab();
                    else if (e.key === 'ArrowRight') this.nextTab();
                });
            },
            
            async loadAllStatistics() {
                try {
                    this.statistics.academic = await fetchStatistics('academic');
                    this.statistics.events = await fetchStatistics('events');
                    this.statistics.services = await fetchStatistics('services');
                    this.statistics.tech = await fetchStatistics('tech');
                    
                    this.updateUI();
                    
                    updateSocialCounts();
                } catch (error) {
                    console.error('Failed to load statistics:', error);
                    this.updateUIWithHardcodedData();
                }
            },
            
            updateUI() {
                const stats = this.statistics[this.activeTab];
                if (!stats || stats.length === 0) {
                    this.updateUIWithHardcodedData();
                    return;
                }
                
                updateElementsWithStats(stats);
            },
            
            updateUIWithHardcodedData() {
                const hardcodedStats = [
                    { key: 'academic_work_qualification', value: '3530', formatted_value: '3 530' },
                    { key: 'academic_mid_specialist', value: '1170', formatted_value: '1 170' },
                    { key: 'academic_applied_bachelor', value: '177', formatted_value: '177' },
                    { key: 'academic_contingent_gz', value: '2500', formatted_value: '2 500' },
                    { key: 'academic_contingent_cgz', value: '800', formatted_value: '800' },
                    { key: 'academic_contingent_paid', value: '577', formatted_value: '577' },
                    { key: 'academic_foreign_language_teachers', value: '42', formatted_value: '42' },
                    { key: 'academic_total_ipr', value: '80', formatted_value: '80' },
                    { key: 'admission_gz', value: '150', formatted_value: '150' },
                    { key: 'admission_cgz', value: '50', formatted_value: '50' },
                    { key: 'admission_paid', value: '12', formatted_value: '12' },
                    { key: 'admin_portal_visits', value: '5', formatted_value: '5' },
                    { key: 'tech_building_students', value: '1934', formatted_value: '1 934' },
                    { key: 'tech_building_teachers', value: '341', formatted_value: '341' },
                    { key: 'tech_building_staff', value: '100', formatted_value: '100' },
                    { key: 'tech_building_total', value: '2375', formatted_value: '2 375' },
                    { key: 'it_accounts_students', value: '8596', formatted_value: '8 596' },
                    { key: 'it_accounts_teachers', value: '625', formatted_value: '625' },
                    { key: 'tech_video_lectures', value: '176', formatted_value: '176' },
                    { key: 'tech_educational_publications', value: '319', formatted_value: '319' },
                    { key: 'tech_mobile_resources', value: '41', formatted_value: '41' },
                    { key: 'teachers_transport', value: '11', formatted_value: '11' },
                    { key: 'teachers_computers', value: '7', formatted_value: '7' },
                    { key: 'teachers_automation', value: '17', formatted_value: '17' },
                    { key: 'teachers_sports', value: '5', formatted_value: '5' },
                    { key: 'teachers_general', value: '13', formatted_value: '13' }
                ];
                
                updateElementsWithStats(hardcodedStats);
                
                if (this.activeTab === 'services') {
                    const teachersData = [11, 7, 17, 5, 13];
                    if (chartInstances['teachersChart']) {
                        chartInstances['teachersChart'].data.datasets[0].data = teachersData;
                        chartInstances['teachersChart'].update();
                        updateTeachersChartNumbers(teachersData);
                    }
                }
            },
            
            updateClock() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                document.getElementById('clock').textContent = `${hours}:${minutes}`;
                
                const options = { day: 'numeric', month: 'long', year: 'numeric' };
                const dateStr = now.toLocaleDateString('ru-RU', options);
                document.getElementById('date').textContent = dateStr;
            },
            
            switchTab(tab, direction = 'left') {
                this.activeTab = tab;
                this.updateUI();
            },
            
            previousTab() {
                const currentIndex = this.tabs.indexOf(this.activeTab);
                const previousIndex = (currentIndex - 1 + this.tabs.length) % this.tabs.length;
                this.activeTab = this.tabs[previousIndex];
                this.updateUI();
            },
            
            nextTab() {
                const currentIndex = this.tabs.indexOf(this.activeTab);
                const nextIndex = (currentIndex + 1) % this.tabs.length;
                this.activeTab = this.tabs[nextIndex];
                this.updateUI();
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        window.dashboardApp = dashboard();
        Alpine.data('dashboard', () => window.dashboardApp);
        
        setTimeout(() => {
            if (window.dashboardApp && window.dashboardApp.init) {
                window.dashboardApp.init();
            }
        }, 200);
    });
</script>
</body>
</html>