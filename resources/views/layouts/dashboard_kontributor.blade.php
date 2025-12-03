<!doctype html>
<html lang="id">

<head>
<!-- layouts/dashboard_kontributor.blade.php -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title','Dashboard') - Jejak Layar</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>@yield('title', 'Dashboard Kontributor') - Jejak Layar</title>

    {{-- Vite / Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font & Icons --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary: #f59e0b;
      --primary-dark: #d97706;
      --primary-light: #fbbf24;
      --accent: #06b6d4;
      --accent-dark: #0891b2;
      --sidebar-grad: linear-gradient(180deg, #fbbf24 0%, #f59e0b 100%);
      --bg-page: #FAFBFF;
      --text-dark: #071027;
      --text-muted: rgba(7, 16, 39, 0.6);
      --border: rgba(2, 6, 23, 0.08);
      --sidebar-bg: #ffffff;
      --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
      --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
      --shadow-premium: 0 6px 20px rgba(2, 6, 23, 0.06);
      --active-glow: rgba(245, 158, 11, 0.18);
    }
    <style>
        :root {
            --yellow-1: #fcd34d;
            --yellow-2: #f4b400;
            --sidebar-grad: linear-gradient(180deg, var(--yellow-1) 0%, var(--yellow-2) 100%);
            --bg-page: #FAFBFF;
            --text-dark: #071027;
            --muted: rgba(7, 16, 39, 0.6);
            --shadow-sm: 0 6px 20px rgba(2, 6, 23, 0.06);
            --active-glow: rgba(244, 180, 0, 0.18);
        }

    body { 
      font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
      background: var(--bg-page);
      color: var(--text-dark);
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    /* ===================== SIDEBAR STYLING ===================== */
    aside#sidebar {
      min-width: 18rem;
      background: var(--sidebar-grad);
      display: flex;
      flex-direction: column;
      box-shadow: 0 20px 45px rgba(245, 158, 11, 0.15);
      border-right: 1px solid rgba(255, 255, 255, 0.3);
      position: sticky;
      top: 0;
      height: 100vh;
      padding-bottom: 20px;
      overflow-y: auto;
      animation: sidebarSlideIn 0.55s ease forwards;
      transform: translateX(-20px);
      opacity: 0;
    }

    @keyframes sidebarSlideIn {
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    /* Subtle shadow effect on the right side */
    aside#sidebar::after {
      content: "";
      position: absolute;
      right: -25px;
      top: 0;
      width: 80px;
      height: 100%;
      background: linear-gradient(90deg, rgba(245, 158, 11, 0.08), transparent);
      filter: blur(20px);
      pointer-events: none;
    }
        body {
            font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, Arial;
            background: var(--bg-page);
            color: var(--text-dark);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        aside#sidebar {
            min-width: 18rem;
            background: var(--sidebar-grad);
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.10);
            border-right: 1px solid rgba(255, 255, 255, 0.25);
            position: sticky;
            top: 0;
            height: 100vh;
            padding-bottom: 20px;
            overflow-y: auto;
            animation: sidebarFade 0.55s ease forwards;
            transform: translateX(-18px);
            opacity: 0;
        }

        @keyframes sidebarFade {
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        aside#sidebar::after {
            content: "";
            position: absolute;
            right: -25px;
            top: 0;
            width: 80px;
            height: 100%;
            background: linear-gradient(90deg, rgba(0, 0, 0, 0.06), transparent);
            filter: blur(18px);
            pointer-events: none;
        }

    .sidebar-brand {
      padding: 1.5rem 1rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.25);
      display: flex;
      align-items: center;
      gap: 0.75rem;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
    }

    .sidebar-brand img {
      width: 64px;
      height: 64px;
      object-fit: contain;
      border-radius: 12px;
      background: white;
      padding: 8px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
      transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.4s ease;
    }

    .sidebar-brand img:hover {
      transform: scale(1.08) rotate(2deg);
      box-shadow: 0 12px 32px rgba(0, 0, 0, 0.18);
    }

    .sidebar-brand .title {
      font-weight: 700;
      font-size: 1.125rem;
      color: var(--text-dark);
      line-height: 1.2;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .sidebar-brand .subtitle {
      font-size: 0.72rem;
      color: rgba(7, 16, 39, 0.7);
      margin-top: 2px;
      font-weight: 500;
    }

    /* ===================== NAVIGATION ===================== */
    aside#sidebar nav {
      padding: 1rem 0.75rem;
      flex: 1;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
    }

    .nav-section-title {
      font-size: 0.7rem;
      font-weight: 700;
      color: rgba(7, 16, 39, 0.65);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      margin: 1rem 0 0.5rem;
      padding: 0 0.75rem;
    }

    .nav-section-title:first-child {
      margin-top: 0;
    }

    aside#sidebar nav a {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.85rem 0.95rem;
      border-radius: 10px;
      text-decoration: none;
      color: rgba(7, 16, 39, 0.95);
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
      font-size: 0.875rem;
      font-weight: 600;
      position: relative;
      background: transparent;
    }

    aside#sidebar nav a i {
      width: 20px;
      text-align: center;
      color: rgba(7, 16, 39, 0.85);
      font-size: 1.05rem;
      transition: all 0.3s ease;
    }

    aside#sidebar nav a:hover {
      background: rgba(255, 255, 255, 0.25);
      transform: translateX(4px) translateY(-2px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    aside#sidebar nav a:hover i {
      transform: scale(1.15);
      color: var(--text-dark);
    }

    /* Active state with premium glow effect */
    aside#sidebar nav a.sidebar-active {
      background: rgba(255, 255, 255, 0.95);
      color: var(--primary-dark);
      transform: translateX(4px) translateY(-2px);
      box-shadow: 0 10px 28px rgba(245, 158, 11, 0.35), 
                  0 0 0 1px rgba(245, 158, 11, 0.1),
                  inset 0 1px 0 rgba(255, 255, 255, 0.8);
      animation: activeGlow 2.5s ease-in-out infinite;
    }

    aside#sidebar nav a.sidebar-active i {
      color: var(--primary);
      transform: scale(1.1);
    }

    aside#sidebar nav a.sidebar-active::before {
      content: "";
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 4px;
      height: 60%;
      background: linear-gradient(180deg, var(--primary), var(--primary-dark));
      border-radius: 0 4px 4px 0;
      box-shadow: 0 0 12px rgba(245, 158, 11, 0.5);
    }

    @keyframes activeGlow {
      0%, 100% {
        box-shadow: 0 10px 28px rgba(245, 158, 11, 0.35), 
                    0 0 0 1px rgba(245, 158, 11, 0.1),
                    inset 0 1px 0 rgba(255, 255, 255, 0.8);
      }
      50% {
        box-shadow: 0 12px 32px rgba(245, 158, 11, 0.45), 
                    0 0 0 1px rgba(245, 158, 11, 0.15),
                    inset 0 1px 0 rgba(255, 255, 255, 0.9);
      }
    }

    /* ===================== SIDEBAR FOOTER ===================== */
    .sidebar-footer {
      margin-top: auto;
      padding: 1rem;
      border-top: 1px solid rgba(255, 255, 255, 0.25);
      background: rgba(255, 255, 255, 0.08);
    }

    .sidebar-footer button {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.65rem;
      padding: 0.85rem 1rem;
      border-radius: 10px;
      background: white;
      color: #dc2626;
      font-weight: 600;
      font-size: 0.875rem;
      border: none;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      cursor: pointer;
    }

    .sidebar-footer button:hover {
      background: #fef2f2;
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(220, 38, 38, 0.2);
    }

    .sidebar-footer button i {
      font-size: 1rem;
    }

    /* ===================== TOPBAR ===================== */
    .topbar {
      background: white;
      border-bottom: 1px solid var(--border);
      position: sticky;
      top: 0;
      z-index: 20;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
      backdrop-filter: blur(10px);
    }

    .topbar-inner {
      max-width: 100%;
      margin: 0 auto;
      padding: 1rem 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
    }

    .page-title {
      font-size: 1.75rem;
      font-weight: 700;
      color: var(--text-dark);
      margin: 0;
      background: linear-gradient(135deg, var(--text-dark), var(--primary-dark));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .page-subtitle {
      font-size: 0.875rem;
      color: var(--text-muted);
      margin-top: 0.25rem;
      font-weight: 500;
    }

    #btn-menu {
      padding: 0.65rem;
      border-radius: 10px;
      background: white;
      border: 1px solid var(--border);
      color: var(--text-dark);
      transition: all 0.2s ease;
      cursor: pointer;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    #btn-menu:hover {
      background: var(--bg-page);
      transform: scale(1.05);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* ===================== USER AVATAR ===================== */
    .user-info {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .user-details {
      text-align: right;
    }

    .user-name {
      font-weight: 600;
      font-size: 0.875rem;
      color: var(--text-dark);
    }

    .user-role {
      font-size: 0.75rem;
      color: var(--text-muted);
      text-transform: capitalize;
    }

    .user-avatar {
      width: 44px;
      height: 44px;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 0.95rem;
      box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
      transition: all 0.3s ease;
      border: 3px solid white;
    }

    .user-avatar:hover {
      transform: scale(1.1) rotate(5deg);
      box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
    }

    /* ===================== MOBILE DRAWER ===================== */
    #mobile-drawer {
      position: fixed;
      inset: 0;
      z-index: 50;
      display: none;
    }

    #mobile-drawer.active {
      display: block;
    }

    .drawer-backdrop {
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.6);
      animation: fadeIn 0.25s ease;
      backdrop-filter: blur(4px);
    }

    .drawer-sidebar {
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 300px;
      max-width: 85vw;
      background: var(--sidebar-grad);
      overflow-y: auto;
      animation: slideInLeft 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 4px 0 24px rgba(0, 0, 0, 0.2);
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideInLeft {
      from { 
        transform: translateX(-100%);
        opacity: 0;
      }
      to { 
        transform: translateX(0);
        opacity: 1;
      }
    }

    /* ===================== FLASH MESSAGES ===================== */
    .flash-message {
      padding: 1.25rem 1.5rem;
      border-radius: 12px;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: start;
      gap: 1rem;
      animation: slideDown 0.4s ease, fadeIn 0.4s ease;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
      border: 1px solid;
      position: relative;
      overflow: hidden;
    }

    .flash-message::before {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 5px;
    }

    .flash-success {
      background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
      color: #065f46;
      border-color: #6ee7b7;
    }

    .flash-success::before {
      background: linear-gradient(180deg, #10b981, #059669);
    }

    .flash-success i {
      color: #059669;
      font-size: 1.25rem;
    }

    .flash-error {
      background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
      color: #991b1b;
      border-color: #fca5a5;
    }

    .flash-error::before {
      background: linear-gradient(180deg, #ef4444, #dc2626);
    }

    .flash-error i {
      color: #dc2626;
      font-size: 1.25rem;
    }

    .flash-message .flash-content {
      flex: 1;
    }

    .flash-message .flash-title {
      font-weight: 600;
      font-size: 0.95rem;
      margin-bottom: 0.25rem;
    }

    .flash-message .flash-text {
      font-size: 0.875rem;
      line-height: 1.5;
    }

    .flash-message ul {
      margin-top: 0.5rem;
      padding-left: 1.25rem;
    }

    .flash-message li {
      margin-bottom: 0.25rem;
      font-size: 0.875rem;
    }

    @keyframes slideDown {
      from {
        transform: translateY(-20px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    /* ===================== MAIN CONTENT ===================== */
    main {
      flex: 1;
      overflow-y: auto;
      padding: 1.5rem;
      background: var(--bg-page);
    }

    main .content-wrapper {
      max-width: 1400px;
      margin: 0 auto;
    }

    /* ===================== CARDS ===================== */
    .card {
      background: white;
      border-radius: 16px;
      padding: 1.5rem;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
      border: 1px solid var(--border);
      transition: all 0.3s ease;
    }

    .card:hover {
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      transform: translateY(-2px);
    }

    .card-title {
      font-size: 1.125rem;
      font-weight: 700;
      color: var(--text-dark);
      margin-bottom: 0.5rem;
    }

    .card-subtitle {
      font-size: 0.875rem;
      color: var(--text-muted);
      margin-bottom: 1rem;
    }

    /* ===================== BUTTONS ===================== */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      padding: 0.75rem 1.5rem;
      border-radius: 10px;
      font-weight: 600;
      font-size: 0.875rem;
      transition: all 0.2s ease;
      cursor: pointer;
      text-decoration: none;
      border: none;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .btn:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
    }

    .btn-primary:hover:not(:disabled) {
      background: linear-gradient(135deg, var(--primary-dark), #b45309);
      box-shadow: 0 4px 16px rgba(245, 158, 11, 0.3);
      transform: translateY(-2px);
    }

    .btn-secondary {
      background: white;
      color: var(--text-dark);
      border: 1px solid var(--border);
    }

    .btn-secondary:hover:not(:disabled) {
      background: var(--bg-page);
      border-color: var(--primary-light);
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    .btn-accent {
      background: linear-gradient(135deg, var(--accent), var(--accent-dark));
      color: white;
    }

    .btn-accent:hover:not(:disabled) {
      background: linear-gradient(135deg, var(--accent-dark), #0e7490);
      box-shadow: 0 4px 16px rgba(6, 182, 212, 0.3);
      transform: translateY(-2px);
    }

    .btn-danger {
      background: linear-gradient(135deg, #ef4444, #dc2626);
      color: white;
    }

    .btn-danger:hover:not(:disabled) {
      background: linear-gradient(135deg, #dc2626, #b91c1c);
      box-shadow: 0 4px 16px rgba(239, 68, 68, 0.3);
      transform: translateY(-2px);
    }

    .btn-sm {
      padding: 0.5rem 1rem;
      font-size: 0.8125rem;
    }

    .btn-lg {
      padding: 1rem 2rem;
      font-size: 1rem;
    }

    /* ===================== BADGES ===================== */
    .badge {
      display: inline-flex;
      align-items: center;
      gap: 0.375rem;
      padding: 0.375rem 0.875rem;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.025em;
    }

    .badge-success {
      background: linear-gradient(135deg, #d1fae5, #a7f3d0);
      color: #065f46;
      border: 1px solid #6ee7b7;
    }

    .badge-warning {
      background: linear-gradient(135deg, #fef3c7, #fde68a);
      color: #92400e;
      border: 1px solid #fcd34d;
    }

    .badge-danger {
      background: linear-gradient(135deg, #fee2e2, #fecaca);
      color: #991b1b;
      border: 1px solid #fca5a5;
    }

    .badge-info {
      background: linear-gradient(135deg, #dbeafe, #bfdbfe);
      color: #1e40af;
      border: 1px solid #93c5fd;
    }

    .badge-primary {
      background: linear-gradient(135deg, #fef3c7, #fde68a);
      color: #92400e;
      border: 1px solid var(--primary-light);
    }

    /* ===================== FORMS ===================== */
    .form-group {
      margin-bottom: 1.25rem;
    }

    .form-label {
      display: block;
      font-size: 0.875rem;
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 0.5rem;
    }

    .form-label .required {
      color: #dc2626;
      margin-left: 0.25rem;
    }

    .form-input,
    .form-select,
    .form-textarea {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1px solid var(--border);
      border-radius: 10px;
      font-size: 0.875rem;
      color: var(--text-dark);
      background: white;
      transition: all 0.2s ease;
      font-family: inherit;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    .form-textarea {
      resize: vertical;
      min-height: 120px;
    }

    .form-help {
      font-size: 0.8125rem;
      color: var(--text-muted);
      margin-top: 0.375rem;
    }

    .form-error {
      font-size: 0.8125rem;
      color: #dc2626;
      margin-top: 0.375rem;
      display: flex;
      align-items: center;
      gap: 0.375rem;
    }

    /* ===================== TABLES ===================== */
    .table-wrapper {
      overflow-x: auto;
      border-radius: 12px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
      border: 1px solid var(--border);
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      background: white;
    }

    .table thead {
      background: linear-gradient(135deg, #fef3c7, #fde68a);
      border-bottom: 2px solid var(--primary-light);
    }

    .table th {
      padding: 1rem 1.25rem;
      text-align: left;
      font-size: 0.8125rem;
      font-weight: 700;
      color: var(--text-dark);
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .table td {
      padding: 1rem 1.25rem;
      font-size: 0.875rem;
      color: var(--text-dark);
      border-bottom: 1px solid var(--border);
    }

    .table tbody tr {
      transition: all 0.2s ease;
    }

    .table tbody tr:hover {
      background: #fffbeb;
    }

    .table tbody tr:last-child td {
      border-bottom: none;
    }

    /* ===================== RESPONSIVE ===================== */
    @media (max-width: 768px) {
      aside#sidebar {
        display: none;
      }

      .page-title {
        font-size: 1.35rem;
      }

      .topbar-inner {
        padding: 0.875rem 1rem;
      }

      main {
        padding: 1rem;
      }

      .card {
        padding: 1.25rem;
      }

      .user-details {
        display: none;
      }

      .user-avatar {
        width: 40px;
        height: 40px;
        font-size: 0.875rem;
      }
    }

    @media (max-width: 640px) {
      .btn {
        padding: 0.65rem 1.25rem;
        font-size: 0.8125rem;
      }

      .page-title {
        font-size: 1.125rem;
      }

      .flash-message {
        padding: 1rem;
        flex-direction: column;
        gap: 0.75rem;
      }
    }

    /* ===================== SCROLLBAR ===================== */
    ::-webkit-scrollbar {
      width: 10px;
      height: 10px;
    }

    ::-webkit-scrollbar-track {
      background: transparent;
    }

    ::-webkit-scrollbar-thumb {
      background: linear-gradient(180deg, #d1d5db, #9ca3af);
      border-radius: 6px;
      border: 2px solid transparent;
      background-clip: padding-box;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(180deg, #9ca3af, #6b7280);
      background-clip: padding-box;
    }

    /* Scrollbar for sidebar */
    aside#sidebar::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.5);
      border-radius: 6px;
    }

    aside#sidebar::-webkit-scrollbar-thumb:hover {
      background: rgba(255, 255, 255, 0.7);
    }

    /* ===================== UTILITIES ===================== */
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-muted { color: var(--text-muted); }
    
    .mt-1 { margin-top: 0.25rem; }
    .mt-2 { margin-top: 0.5rem; }
    .mt-3 { margin-top: 0.75rem; }
    .mt-4 { margin-top: 1rem; }
    .mt-6 { margin-top: 1.5rem; }
    
    .mb-1 { margin-bottom: 0.25rem; }
    .mb-2 { margin-bottom: 0.5rem; }
    .mb-3 { margin-bottom: 0.75rem; }
    .mb-4 { margin-bottom: 1rem; }
    .mb-6 { margin-bottom: 1.5rem; }
    
    .p-4 { padding: 1rem; }
    .p-6 { padding: 1.5rem; }
    
    .flex { display: flex; }
    .flex-col { flex-direction: column; }
    .items-center { align-items: center; }
    .justify-between { justify-content: space-between; }
    .gap-2 { gap: 0.5rem; }
    .gap-4 { gap: 1rem; }
    
    .rounded { border-radius: 0.5rem; }
    .rounded-lg { border-radius: 0.75rem; }
    
    .shadow { box-shadow: var(--shadow); }
    .shadow-lg { box-shadow: var(--shadow-lg); }
    
    .transition { transition: all 0.2s ease; }

    /* ===================== LOADING STATES ===================== */
    .skeleton {
      background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
      background-size: 200% 100%;
      animation: shimmer 1.5s infinite;
      border-radius: 8px;
    }

    @keyframes shimmer {
      0% { background-position: 200% 0; }
      100% { background-position: -200% 0; }
    }

    .spinner {
      border: 3px solid rgba(245, 158, 11, 0.2);
      border-top-color: var(--primary);
      border-radius: 50%;
      width: 24px;
      height: 24px;
      animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: 1rem;
            border-bottom: 1px solid rgba(2, 6, 23, 0.04);
        }

        .sidebar-brand img {
            width: 78px;
            height: 78px;
            object-fit: contain;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(2, 6, 23, 0.06);
            transition: transform .4s ease, box-shadow .4s ease;
        }

        .sidebar-brand img:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .sidebar-brand .title {
            font-weight: 700;
            color: var(--text-dark);
            font-size: 1.05rem;
        }

        .sidebar-brand .subtitle {
            font-size: .72rem;
            color: var(--muted);
            margin-top: 2px;
        }

        aside#sidebar nav {
            padding: .75rem;
            display: flex;
            flex-direction: column;
            gap: .25rem;
            overflow: auto;
        }

        aside#sidebar nav a {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .8rem .9rem;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-dark);
            background: transparent;
            transition: background .18s ease, transform .18s ease, box-shadow .25s ease, filter .25s ease;
            position: relative;
            cursor: pointer;
        }

        aside#sidebar nav a i {
            width: 1.2rem;
            text-align: center;
            color: rgba(3, 16, 38, 0.9);
            font-size: 1.05rem;
        }

        aside#sidebar nav a span {
            font-weight: 600;
            color: rgba(3, 16, 38, 0.95);
        }

        aside#sidebar nav a:hover {
            background: rgba(255, 255, 255, 0.20);
            transform: translateY(-4px);
            box-shadow: 0 12px 26px rgba(0, 0, 0, 0.10);
        }

        aside#sidebar nav a:hover i {
            animation: iconPop .45s ease;
        }

        @keyframes iconPop {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.25);
            }

            100% {
                transform: scale(1);
            }
        }

        aside#sidebar nav a.sidebar-active {
            background: rgba(255, 255, 255, 0.95);
            color: var(--text-dark);
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(255, 220, 80, 0.35), 0 0 20px rgba(255, 200, 0, 0.4);
            animation: activePulse 2s ease-in-out infinite;
            z-index: 2;
        }

        aside#sidebar nav a.sidebar-active::after {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 6px;
            background: linear-gradient(180deg, var(--yellow-2), var(--yellow-1));
            box-shadow: 0 0 18px rgba(255, 200, 40, 0.5);
        }

        @keyframes activePulse {
            0% {
                box-shadow: 0 12px 32px rgba(255, 220, 80, 0.35), 0 0 12px rgba(255, 200, 0, 0.2);
            }

            50% {
                box-shadow: 0 14px 40px rgba(255, 220, 80, 0.45), 0 0 20px rgba(255, 200, 0, 0.35);
            }

            100% {
                box-shadow: 0 12px 32px rgba(255, 220, 80, 0.35), 0 0 12px rgba(255, 200, 0, 0.2);
            }
        }

        .sidebar-section-title {
            margin: .5rem .5rem;
            font-size: .68rem;
            color: var(--muted);
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: .75rem;
            border-top: 1px solid rgba(2, 6, 23, 0.03);
        }

        .sidebar-footer button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .6rem .8rem;
            border-radius: .6rem;
            background: #fff;
            color: var(--text-dark);
            font-weight: 600;
            border: none;
            box-shadow: 0 6px 20px rgba(2, 6, 23, 0.06);
            transition: all .25s ease;
        }

        .sidebar-footer button:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.18);
        }

        aside#sidebar::-webkit-scrollbar {
            width: 8px;
        }

        aside#sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.45);
            border-radius: 6px;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid rgba(2, 6, 23, 0.04);
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .page-sub {
            color: var(--muted);
            font-size: .94rem;
        }

        .focus-ring:focus {
            outline: 3px solid rgba(244, 180, 0, 0.14);
            outline-offset: 3px;
            border-radius: .5rem;
        }

        @media (max-width: 768px) {
            aside#sidebar {
                display: none;
            }

            .sidebar-brand img {
                width: 56px;
                height: 56px;
            }
        }
    </style>
</head>
<body>

<body class="bg-[color:var(--bg-page)] text-[color:var(--text-dark)] antialiased">

    <div class="min-h-screen flex">

    <!-- ===================== SIDEBAR (Desktop) ===================== -->
    <aside id="sidebar" class="hidden md:flex flex-col">
      <div class="sidebar-brand">
        <img src="{{ asset('images/Logo Header.png') }}" alt="Jejak Layar">
        <div>
          <div class="title">Jejak Layar</div>
          <div class="subtitle">Arsip Budaya Nusantara</div>
        </div>
      </div>
        <!-- SIDEBAR (desktop) -->
        <aside id="sidebar" class="hidden md:flex flex-col">
            <div class="sidebar-brand">
                <a href="{{ url('/') }}" class="flex items-center gap-3" aria-label="Beranda Jejak Layar">
                    <img src="{{ asset('images/LogoJejakLayar.png') }}" alt="Jejak Layar">
                    <div>
                        <div class="title">Jejak Layar</div>
                        <div class="subtitle">Panel Kontributor</div>
                    </div>
                </a>
            </div>

      <nav aria-label="Sidebar Navigation">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'sidebar-active' : '' }}">
          <i class="fa fa-home"></i>
          <span>Beranda</span>
        </a>

        <div class="nav-section-title">Kontributor</div>
            <!-- SIDEBAR NAVIGATION -->
            <nav class="flex-1 overflow-y-auto px-2 pb-6" aria-label="Sidebar Navigation">
                <div class="px-2">

                    {{-- ================= MENU KONTRIBUTOR ================= --}}
                    <div class="sidebar-section-title">Menu Utama</div>

        <a href="{{ route('kontributor.dashboard') }}" class="{{ request()->routeIs('kontributor.dashboard') ? 'sidebar-active' : '' }}">
          <i class="fa fa-chart-line"></i>
          <span>Dashboard</span>
        </a>
                    <a href="{{ route('kontributor.dashboard') }}"
                        class="{{ request()->routeIs('kontributor.dashboard') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2"
                        title="Dashboard">
                        <i class="fa fa-home"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>

        <a href="{{ route('kontributor.articles.create') }}" class="{{ request()->routeIs('kontributor.articles.create') ? 'sidebar-active' : '' }}">
          <i class="fa fa-pen-nib"></i>
          <span>Tulis Artikel</span>
        </a>
                    <a href="{{ route('kontributor.artikel.create') }}"
                        class="{{ request()->routeIs('kontributor.artikel.create') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2"
                        title="Upload Artikel">
                        <i class="fa fa-plus-circle"></i>
                        <span class="ml-3">Upload Artikel</span>
                    </a>

        <a href="{{ route('kontributor.articles.index') }}" class="{{ request()->routeIs('kontributor.articles.*') && !request()->routeIs('kontributor.articles.create') ? 'sidebar-active' : '' }}">
          <i class="fa fa-file-alt"></i>
          <span>Artikel Saya</span>
        </a>
                    <a href="{{ route('kontributor.artikel.index') }}"
                        class="{{ request()->routeIs('kontributor.artikel.index') || request()->routeIs('kontributor.artikel.edit') || request()->routeIs('kontributor.artikel.show') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2"
                        title="Artikel Saya">
                        <i class="fa fa-file-alt"></i>
                        <span class="ml-3">Artikel Saya</span>
                    </a>

        <a href="{{ route('kontributor.profil') }}" class="{{ request()->routeIs('kontributor.profil') ? 'sidebar-active' : '' }}">
          <i class="fa fa-user"></i>
          <span>Profil Saya</span>
        </a>
                    {{-- ================= PROFIL ================= --}}
                    <div class="sidebar-section-title">Profil</div>

                    <a href="{{ route('kontributor.profil.edit') }}"
                        class="{{ request()->routeIs('kontributor.profil.edit') ? 'sidebar-active' : '' }} rounded-lg focus-ring mt-2"
                        title="Edit Profil">
                        <i class="fa fa-user-circle"></i>
                        <span class="ml-3">Edit Profil</span>
                    </a>

        @if(auth()->check() && auth()->user()->role === 'admin')
          <div class="nav-section-title">Admin</div>
          <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'sidebar-active' : '' }}">
            <i class="fa fa-cog"></i>
            <span>Panel Admin</span>
          </a>
        @endif
      </nav>
                    {{-- ================= LAINNYA ================= --}}
                    <div class="sidebar-section-title">Lainnya</div>

                    <a href="{{ route('kontributor.artikel.index') }}"
                        class="rounded-lg focus-ring mt-2"
                        title="Lihat Artikel Publik">
                        <i class="fa fa-globe"></i>
                        <span class="ml-3">Lihat Artikel Publik</span>
                    </a>

                </div>
            </nav>

      <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit">
            <i class="fa fa-sign-out-alt"></i>
            <span>Keluar</span>
          </button>
        </form>
      </div>
    </aside>
            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST" class="px-4 py-3">
                    @csrf
                    <button type="submit" title="Logout">
                        <i class="fa fa-sign-out-alt"></i><span class="ml-2">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

    <!-- ===================== MAIN CONTENT ===================== -->
    <div class="flex-1 flex flex-col min-h-screen">
      <!-- TOPBAR -->
      <header class="topbar">
        <div class="topbar-inner">
          <div class="flex items-center gap-4">
            <button id="btn-menu" class="md:hidden" aria-label="Buka menu">
              <i class="fa fa-bars text-lg"></i>
            </button>
        <!-- MAIN -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- TOPBAR -->
            <header class="topbar">
                <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <button id="btn-open-sidebar" class="md:hidden p-2 rounded bg-white shadow-sm"
                            aria-label="Buka menu">
                            <i class="fa fa-bars"></i>
                        </button>

            <div>
              <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
              @hasSection('page-subtitle')
                <p class="page-subtitle">@yield('page-subtitle')</p>
              @endif
            </div>
          </div>
                        <div>
                            <h1 class="page-title">@yield('page-title', 'Dashboard Kontributor')</h1>
                            <p class="page-sub">@yield('page-subtitle', 'Kelola artikel dan profil Anda')</p>
                        </div>
                    </div>

          <div class="user-info">
            <div class="user-details hidden sm:block">
              <div class="user-name">{{ auth()->user()->name ?? 'Pengguna' }}</div>
              <div class="user-role">{{ ucfirst(auth()->user()->role ?? 'kontributor') }}</div>
            </div>
            <div class="user-avatar">
              {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
          </div>
        </div>
      </header>
                    <div class="flex items-center gap-4">
                        <div class="text-sm text-[color:var(--muted)]">{{ auth()->user()->name ?? 'Kontributor' }}</div>
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center text-white shadow-sm font-semibold">
                            {{ strtoupper(substr(auth()->user()->name ?? 'K', 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

      <!-- PAGE CONTENT -->
      <main>
        <div class="content-wrapper">
          @if(session('success'))
            <div class="flash-message flash-success">
              <i class="fa fa-check-circle"></i>
              <div class="flash-content">
                <div class="flash-title">Berhasil!</div>
                <div class="flash-text">{{ session('success') }}</div>
              </div>
            </div>
          @endif

          @if(session('error'))
            <div class="flash-message flash-error">
              <i class="fa fa-exclamation-circle"></i>
              <div class="flash-content">
                <div class="flash-title">Terjadi Kesalahan</div>
                <div class="flash-text">{{ session('error') }}</div>
              </div>
            </div>
          @endif

          @if($errors->any())
            <div class="flash-message flash-error">
              <i class="fa fa-exclamation-circle"></i>
              <div class="flash-content">
                <div class="flash-title">Terjadi kesalahan:</div>
                <ul>
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
          @endif

          @yield('content')
        </div>
      </main>
    </div>
  </div>
            <!-- PAGE -->
            <main class="p-6 flex-1 overflow-y-auto">
                <div class="max-w-7xl mx-auto">
                    @includeWhen(session('success'), 'components.flash', [
                        'type' => 'success',
                        'message' => session('success'),
                    ])
                    @includeWhen(session('error'), 'components.flash', [
                        'type' => 'error',
                        'message' => session('error'),
                    ])
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

  {{-- ===================== MOBILE DRAWER ===================== --}}
  <div id="mobile-drawer" aria-hidden="true">
    <div class="drawer-backdrop" id="drawer-backdrop"></div>
    <div class="drawer-sidebar">
      <div class="sidebar-brand">
        <img src="{{ asset('images/Logo Header.png') }}" alt="Jejak Layar">
        <div>
          <div class="title">Jejak Layar</div>
          <div class="subtitle">Arsip Budaya Nusantara</div>
        </div>
      </div>
    {{-- MOBILE DRAWER --}}
    <div id="mobile-drawer" class="fixed inset-0 z-50 md:hidden hidden" aria-hidden="true">
        <div id="drawer-backdrop" class="absolute inset-0 bg-black/40"></div>
        <div
            class="absolute left-0 top-0 bottom-0 w-64 bg-gradient-to-b from-yellow-300 to-yellow-400 text-slate-900 p-4 overflow-y-auto">
            <div class="flex items-center gap-3 mb-6">
                <img src="{{ asset('images/LogoJejakLayar.png') }}" alt="logo" class="h-8 w-8">
                <span class="font-semibold">Jejak Layar</span>
            </div>

      <nav>
        <a href="{{ route('home') }}">
          <i class="fa fa-home"></i>
          <span>Beranda</span>
        </a>

        <div class="nav-section-title">Kontributor</div>

        <a href="{{ route('kontributor.dashboard') }}">
          <i class="fa fa-chart-line"></i>
          <span>Dashboard</span>
        </a>

        <a href="{{ route('kontributor.articles.create') }}">
          <i class="fa fa-pen-nib"></i>
          <span>Tulis Artikel</span>
        </a>

        <a href="{{ route('kontributor.articles.index') }}">
          <i class="fa fa-file-alt"></i>
          <span>Artikel Saya</span>
        </a>

        <a href="{{ route('kontributor.profil') }}">
          <i class="fa fa-user"></i>
          <span>Profil Saya</span>
        </a>

        @if(auth()->check() && auth()->user()->role === 'admin')
          <div class="nav-section-title">Admin</div>
          <a href="{{ route('admin.dashboard') }}">
            <i class="fa fa-cog"></i>
            <span>Panel Admin</span>
          </a>
        @endif
      </nav>

      <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit">
            <i class="fa fa-sign-out-alt"></i>
            <span>Keluar</span>
          </button>
        </form>
      </div>
    </div>
  </div>
            <nav class="space-y-1">
                <a href="{{ route('kontributor.dashboard') }}"
                    class="block px-3 py-2 rounded bg-white/5 hover:bg-white/8">Dashboard</a>
                <a href="{{ route('kontributor.artikel.create') }}" 
                    class="block px-3 py-2 rounded hover:bg-white/6">Upload Artikel</a>
                <a href="{{ route('kontributor.artikel.index') }}"
                    class="block px-3 py-2 rounded hover:bg-white/6">Artikel Saya</a>
                <a href="{{ route('kontributor.profil.edit') }}"
                    class="block px-3 py-2 rounded hover:bg-white/6">Edit Profil</a>
                <a href="{{ route('kontributor.artikel.index') }}"
                    class="block px-3 py-2 rounded hover:bg-white/6">Lihat Artikel Publik</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded text-rose-500">Keluar</button>
                </form>
            </nav>
        </div>
    </div>

  <script>
    // ===================== MOBILE DRAWER TOGGLE =====================
    const drawer = document.getElementById('mobile-drawer');
    const btnMenu = document.getElementById('btn-menu');
    const backdrop = document.getElementById('drawer-backdrop');

    if (btnMenu) {
      btnMenu.addEventListener('click', () => {
        drawer.classList.add('active');
        document.body.style.overflow = 'hidden';
      });
    }

    if (backdrop) {
      backdrop.addEventListener('click', () => {
        drawer.classList.remove('active');
        document.body.style.overflow = '';
      });
    }

    // Close drawer on ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && drawer.classList.contains('active')) {
        drawer.classList.remove('active');
        document.body.style.overflow = '';
      }
    });

    // ===================== AUTO-HIDE FLASH MESSAGES =====================
    setTimeout(() => {
      const flashes = document.querySelectorAll('.flash-message');
      flashes.forEach(flash => {
        flash.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
        flash.style.opacity = '0';
        flash.style.transform = 'translateY(-10px)';
        setTimeout(() => flash.remove(), 400);
      });
    }, 5000);

    // ===================== SMOOTH SCROLL =====================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        const targetId = this.getAttribute('href');
        if (targetId !== '#') {
          e.preventDefault();
          const target = document.querySelector(targetId);
          if (target) {
            target.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }
        }
      });
    });

    // ===================== ACTIVE LINK HIGHLIGHT =====================
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('aside#sidebar nav a, .drawer-sidebar nav a');
    
    navLinks.forEach(link => {
      if (link.getAttribute('href') === currentPath) {
        link.classList.add('sidebar-active');
      }
    });

    // ===================== FORM VALIDATION HELPER =====================
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
      form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
          if (!field.value.trim()) {
            isValid = false;
            field.classList.add('border-red-500');
            
            // Add error message if not exists
            if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('form-error')) {
              const error = document.createElement('div');
              error.className = 'form-error';
              error.innerHTML = '<i class="fa fa-exclamation-circle"></i> Field ini wajib diisi';
              field.parentNode.appendChild(error);
            }
          } else {
            field.classList.remove('border-red-500');
            const error = field.parentNode.querySelector('.form-error');
            if (error) error.remove();
          }
        });

        if (!isValid) {
          e.preventDefault();
        }
      });
    });
  </script>
    <script>
        // Mobile drawer toggle
        const drawer = document.getElementById('mobile-drawer');
        const openBtn = document.getElementById('btn-open-sidebar');
        const backdrop = document.getElementById('drawer-backdrop');
        if (openBtn) {
            openBtn.addEventListener('click', () => drawer.classList.remove('hidden'));
            backdrop.addEventListener('click', () => drawer.classList.add('hidden'));
        }
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !drawer.classList.contains('hidden')) {
                drawer.classList.add('hidden');
            }
        });
    </script>
</body>

</html>