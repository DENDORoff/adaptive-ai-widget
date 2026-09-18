@extends('layouts.app')

@section('title', \App\Models\PageSection::getValue('youth_movement', 'hero_header', 'page_title', 'Молодёжный движ'))

@section('content')
<style>
    .youth-movement-page {
        background: linear-gradient(to bottom, #0f172a, #000, #0f172a);
        color: white;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
        line-height: 1.6;
        width: 100%;
        max-width: 100vw;
        overflow-x: hidden;
        position: relative;
        margin: 0;
        padding: 0;
    }

    .youth-background-particles {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        pointer-events: none;
        background: 
            radial-gradient(circle at 20% 30%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(6, 182, 212, 0.08) 0%, transparent 50%);
    }

    @keyframes youth-hero-glow {
        0% { opacity: 0.5; }
        100% { opacity: 1; }
    }

    @keyframes youth-pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
        70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
    }

    @keyframes youth-fade-up {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes youth-gradient-shift {
        0% { background-position: 0% center; }
        100% { background-position: 100% center; }
    }

    @keyframes youth-rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes youth-glow {
        from { box-shadow: 0 0 10px #3b82f6; }
        to { box-shadow: 0 0 20px #3b82f6, 0 0 30px #3b82f6; }
    }

    @keyframes youth-particles-float {
        0% { transform: translateY(0) rotate(0deg); }
        100% { transform: translateY(-100px) rotate(360deg); }
    }

    @keyframes youth-tab-glow {
        0% { box-shadow: 0 0 5px rgba(59, 130, 246, 0.5); }
        100% { box-shadow: 0 0 15px rgba(59, 130, 246, 0.8); }
    }

    @keyframes youth-bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    @keyframes youth-icon-float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(5deg); }
    }

    @keyframes youth-tag-glow {
        0% { box-shadow: 0 0 5px #3b82f6; }
        100% { box-shadow: 0 0 15px #3b82f6; }
    }

    @keyframes youth-score-pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    @keyframes youth-progress-grow {
        from { width: 0; }
    }

    @keyframes youth-title-reveal {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.9);
            filter: blur(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }
    }

    @keyframes youth-text-reveal {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes youth-float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }

    @keyframes youth-orb-float {
        0%, 100% { 
            transform: translate(0, 0) scale(1);
            opacity: 0.3;
        }
        50% { 
            transform: translate(var(--tx, 20px), var(--ty, -20px)) scale(1.1);
            opacity: 0.6;
        }
    }

    @keyframes youth-sparkle {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.8; transform: scale(1.1); }
    }

    @keyframes youth-badge-pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.5); opacity: 0.7; }
    }

    @keyframes youth-grid-move {
        0% { transform: translate(0, 0); }
        100% { transform: translate(40px, 40px); }
    }

    @keyframes youth-bounce-btn {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(5px); }
    }

    @keyframes youth-carousel-slide {
        0% { transform: perspective(1400px) rotateY(30deg) translateX(150px) scale(0.85); opacity: 0; }
        100% { transform: perspective(1400px) rotateY(0) translateX(0) scale(1); opacity: 1; }
    }

    @keyframes youth-carousel-slide-out {
        0% { transform: perspective(1400px) rotateY(0) translateX(0) scale(1); opacity: 1; }
        100% { transform: perspective(1400px) rotateY(-30deg) translateX(-150px) scale(0.85); opacity: 0; }
    }

    .youth-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        width: 100%;
        position: relative;
        z-index: 1;
    }

    .youth-container-wide {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 40px;
        width: 100%;
        position: relative;
        z-index: 1;
    }

    .youth-hero {
        min-height: 70vh;
        padding: 20px 0 40px;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
    }

    .youth-hero-gradient {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 30%, rgba(59, 130, 246, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(168, 85, 247, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 40% 90%, rgba(34, 197, 94, 0.1) 0%, transparent 50%);
        animation: youth-hero-glow 8s ease-in-out infinite alternate;
        z-index: 1;
    }

    .youth-hero-top-center-wide {
        position: absolute;
        top: 10px;
        left: 0;
        right: 0;
        text-align: center;
        z-index: 10;
        width: 100%;
    }

    .youth-hero-top-text-wide {
        display: inline-block;
        padding: 20px 40px;
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        border: 1px solid rgba(59, 130, 246, 0.2);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        min-width: 500px;
    }

    .youth-top-title-line-wide {
        font-size: 1.8rem;
        font-weight: 800;
        color: #fff;
        opacity: 0;
        animation: youth-title-reveal 1s ease forwards;
        margin-bottom: 8px;
        line-height: 1.2;
        letter-spacing: 0.5px;
    }

    .youth-top-title-line-wide:first-child {
        background: linear-gradient(90deg, #8b5cf6, #7c3aed);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .youth-top-title-line-wide:last-child {
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .youth-hero-content-wide {
        position: relative;
        z-index: 3;
        max-width: 1400px;
        margin: 150px auto 0;
        display: grid;
        grid-template-columns: 1.2fr 1.3fr;
        gap: 100px;
        align-items: center;
        padding: 0 40px;
        width: 100%;
    }

    .youth-hero-text-wide {
        position: relative;
        max-width: 700px;
    }

    .youth-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        color: white;
        padding: 12px 25px;
        border-radius: 30px;
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 30px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .youth-badge-dot {
        width: 10px;
        height: 10px;
        background: #fff;
        border-radius: 50%;
        animation: youth-badge-pulse 1.5s infinite;
    }

    .youth-hero-title-wide {
        font-size: clamp(3rem, 5vw, 4.5rem);
        font-weight: 900;
        margin-bottom: 25px;
        line-height: 1;
        position: relative;
        max-width: 800px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .youth-title-reveal {
        display: block;
        opacity: 0;
        animation: youth-title-reveal 1s ease forwards;
    }

    .youth-gradient-text {
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        background-size: 200% auto;
        animation: youth-gradient-shift 3s ease-in-out infinite alternate;
        font-size: clamp(3.5rem, 6vw, 5rem);
        display: block;
        line-height: 1;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .youth-hero-subtitle {
        font-size: 1.3rem;
        color: #cbd5e1;
        margin-bottom: 40px;
        max-width: 700px;
        line-height: 1.6;
        opacity: 0;
        animation: youth-text-reveal 1s ease 0.6s forwards;
    }

    .youth-highlight {
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
        padding: 0 12px;
        border-radius: 4px;
        position: relative;
        font-weight: 600;
    }

    .youth-highlight::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 12px;
        right: 12px;
        height: 2px;
        background: linear-gradient(90deg, transparent, #3b82f6, transparent);
    }

    .youth-hero-actions {
        display: flex;
        gap: 20px;
        opacity: 0;
        animation: youth-text-reveal 1s ease 1.0s forwards;
    }

    .youth-btn-primary {
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        color: white;
        border: none;
        padding: 18px 45px;
        border-radius: 30px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        position: relative;
        overflow: hidden;
    }

    .youth-btn-glow::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(90deg, #3b82f6, #06b6d4, #3b82f6);
        border-radius: 32px;
        z-index: -1;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .youth-btn-sparkle::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(90deg, #3b82f6, #06b6d4, #22c55e, #3b82f6);
        background-size: 300% 300%;
        border-radius: 32px;
        z-index: -1;
        opacity: 0;
        animation: youth-rotate 3s linear infinite;
        transition: opacity 0.3s ease;
    }

    .youth-btn-sparkle:hover::before {
        opacity: 1;
    }

    .youth-btn-glow:hover::before {
        opacity: 1;
        animation: youth-rotate 3s linear infinite;
    }

    .youth-btn-primary:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 20px 40px rgba(59, 130, 246, 0.3);
    }

    .youth-btn-arrow {
        animation: youth-bounce-btn 2s ease infinite;
    }

    .youth-btn-outline {
        background: transparent;
        border: 2px solid rgba(59, 130, 246, 0.3);
        color: white;
        padding: 16px 35px;
        border-radius: 30px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .youth-btn-outline:hover {
        background: rgba(59, 130, 246, 0.1);
        border-color: #3b82f6;
        transform: translateY(-2px);
    }

    .youth-btn-icon {
        font-size: 1.2rem;
    }

    .youth-hero-visual-wide {
        position: relative;
        width: 100%;
        height: 500px;
        margin-left: 0;
        margin-right: 0;
        z-index: 2;
    }

    .youth-photo-carousel-3d-wide {
        position: relative;
        width: 100%;
        height: 100%;
        max-width: 800px;
        margin-left: auto;
        margin-right: 0;
    }

    .youth-carousel-3d-container-wide {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        perspective: 1400px;
    }

    .youth-main-card-wide-horizontal {
        position: absolute;
        width: 120%;
        height: 90%;
        left: 0;
        margin-left: -10%;
        border-radius: 40px;
        overflow: hidden;
        transform: translateZ(0);
        box-shadow: 
            0 50px 100px rgba(0, 0, 0, 0.5),
            0 0 0 2px rgba(59, 130, 246, 0.3);
        background-size: cover;
        background-position: center;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 0;
        opacity: 0;
        transform-style: preserve-3d;
    }

    .youth-carousel-slide {
        position: absolute;
        width: 120%;
        height: 90%;
        left: 0;
        margin-left: -10%;
        border-radius: 40px;
        overflow: hidden;
        background-size: cover;
        background-position: center;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 0;
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        transform: perspective(1400px) rotateY(30deg) translateX(150px) scale(0.85);
        opacity: 0;
        z-index: 1;
    }

    .youth-carousel-slide.youth-active {
        opacity: 1;
        transform: perspective(1400px) rotateY(0) translateX(0) scale(1);
        z-index: 10;
        animation: youth-carousel-slide 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    .youth-carousel-slide.youth-prev {
        transform: perspective(1400px) rotateY(-30deg) translateX(-150px) scale(0.85);
        opacity: 0;
        animation: youth-carousel-slide-out 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    .youth-carousel-slide.youth-next {
        transform: perspective(1400px) rotateY(30deg) translateX(150px) scale(0.85);
        opacity: 0;
    }

    .carousel-card-clickable {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .carousel-card-clickable.youth-active:hover {
        filter: brightness(1.1);
    }

    .youth-card-3d {
        transform-style: preserve-3d;
    }

    .youth-card-overlay-wide {
        background: linear-gradient(transparent, rgba(15, 23, 42, 0.95));
        padding: 35px;
        border-radius: 0 0 40px 40px;
        transform: translateZ(30px);
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        overflow: hidden;
    }
    
    .youth-card-overlay-wide .youth-card-title {
        max-width: 100%;
        overflow-wrap: break-word;
        word-wrap: break-word;
        word-break: break-word;
    }

    .youth-card-badge {
        display: inline-block;
        background: linear-gradient(90deg, #8b5cf6, #7c3aed);
        color: white;
        padding: 12px 30px;
        border-radius: 30px;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 25px;
        width: fit-content;
    }

    .youth-card-title {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 15px;
        color: white;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .youth-card-desc {
        font-size: 1.2rem;
        color: #93c5fd;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .youth-carousel-nav {
        position: absolute;
        bottom: -30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 25px;
        z-index: 20;
        width: auto;
    }

    .youth-nav-btn {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .youth-nav-btn:hover {
        background: rgba(59, 130, 246, 0.2);
        border-color: #3b82f6;
        transform: scale(1.1);
    }

    .youth-carousel-dots {
        display: flex;
        gap: 12px;
    }

    .youth-carousel-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .youth-carousel-dot:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    .youth-carousel-dot.youth-active {
        background: #3b82f6;
        transform: scale(1.3);
    }

    .youth-hero-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        z-index: 1;
    }

    .youth-orb-1 {
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.4), transparent 70%);
        top: 15%;
        left: 10%;
        animation: youth-orb-float 15s ease-in-out infinite;
        --tx: 30px;
        --ty: -30px;
    }

    .youth-orb-2 {
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(168, 85, 247, 0.3), transparent 70%);
        bottom: 25%;
        right: 15%;
        animation: youth-orb-float 12s ease-in-out infinite reverse;
        --tx: -20px;
        --ty: 20px;
    }

    .youth-orb-3 {
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(34, 197, 94, 0.3), transparent 70%);
        top: 65%;
        left: 5%;
        animation: youth-orb-float 18s ease-in-out infinite;
        --tx: 40px;
        --ty: -20px;
    }

    .youth-orb-4 {
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(245, 158, 11, 0.3), transparent 70%);
        top: 25%;
        right: 5%;
        animation: youth-orb-float 14s ease-in-out infinite reverse;
        --tx: -30px;
        --ty: 25px;
    }

    .youth-event-banner {
        padding: 80px 0;
        width: 100%;
    }

    .youth-event-card {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(6, 182, 212, 0.05));
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 30px;
        overflow: hidden;
        display: grid;
        grid-template-columns: 1fr 1fr;
        width: 100%;
        max-width: 100%;
        backdrop-filter: blur(10px);
        position: relative;
    }

    .youth-card-hover {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .youth-card-hover:hover {
        transform: translateY(-10px) scale(1.02);
        border-color: #3b82f6;
        box-shadow: 0 20px 40px rgba(59, 130, 246, 0.2);
    }

    .youth-event-image {
        position: relative;
        min-height: 450px;
        width: 100%;
        overflow: hidden;
    }

    .youth-event-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
    }

    .youth-event-badge {
        position: absolute;
        top: 25px;
        left: 25px;
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        font-size: 1rem;
        font-weight: 600;
        z-index: 2;
    }

    .youth-event-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: 
            radial-gradient(circle at 20% 30%, rgba(59, 130, 246, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(6, 182, 212, 0.3) 0%, transparent 50%);
        animation: youth-particles-float 20s linear infinite;
    }

    .youth-event-content {
        padding: 50px;
        width: 100%;
        min-width: 0;
        overflow-x: hidden;
        display: flex;
        flex-direction: column;
    }

    .youth-event-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 25px;
    }

    .youth-text-gradient {
        background: linear-gradient(90deg, #fff, #93c5fd);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: clamp(2rem, 3.5vw, 2.5rem);
        font-weight: 700;
        margin: 0;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
        min-width: 0;
        width: 100%;
        max-width: 100%;
    }

    .youth-event-timer {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .youth-timer-item {
        text-align: center;
        min-width: 80px;
        background: rgba(59, 130, 246, 0.1);
        border-radius: 15px;
        padding: 12px;
    }

    .youth-timer-value {
        font-size: 2.2rem;
        font-weight: 800;
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: block;
        line-height: 1;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .youth-timer-label {
        font-size: 0.9rem;
        color: #93c5fd;
        margin-top: 5px;
    }

    .youth-timer-divider {
        font-size: 2rem;
        color: #3b82f6;
        margin-top: -10px;
    }

    .youth-event-info {
        display: flex;
        gap: 30px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .youth-info-item {
        display: flex;
        align-items: center;
        gap: 12px;
        white-space: nowrap;
        padding: 12px 25px;
        background: rgba(59, 130, 246, 0.1);
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .youth-info-glow:hover {
        background: rgba(59, 130, 246, 0.2);
        box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);
        transform: translateY(-2px);
    }

    .youth-info-icon {
        font-size: 1.2rem;
    }

    .youth-info-text {
        font-size: 1.05rem;
        white-space: normal;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .youth-event-description {
        color: #cbd5e1;
        line-height: 1.6;
        margin-bottom: 35px;
        font-size: 1.1rem;
        word-wrap: break-word;
        overflow-wrap: break-word;
        white-space: normal;
    }

    .youth-event-actions {
        display: flex;
        gap: 25px;
        flex-wrap: wrap;
    }

    .youth-events-section {
        padding: 100px 0;
        background: rgba(59, 130, 246, 0.05);
        width: 100%;
    }

    .youth-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 50px;
        flex-wrap: wrap;
        gap: 25px;
        width: 100%;
    }

    .youth-section-title {
        font-size: clamp(2rem, 3.5vw, 2.5rem);
        font-weight: 700;
        margin: 0;
        background: linear-gradient(90deg, #fff, #93c5fd);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        min-width: 0;
    }

    .youth-calendar-badge {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        padding: 12px 25px;
        border-radius: 30px;
        color: #93c5fd;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .youth-calendar-badge:hover {
        background: rgba(59, 130, 246, 0.2);
        transform: translateY(-2px);
    }

    .youth-calendar-icon {
        font-size: 1.3rem;
    }

    .youth-events-grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr 1fr;
        gap: 40px;
        width: 100%;
    }

    .youth-events-calendar {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 25px;
        padding: 30px;
        backdrop-filter: blur(10px);
    }

    .youth-calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .youth-calendar-nav {
        background: rgba(59, 130, 246, 0.2);
        border: none;
        color: white;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .youth-calendar-nav:hover {
        background: rgba(59, 130, 246, 0.3);
        transform: scale(1.1);
    }

    .youth-calendar-month {
        font-weight: 600;
        color: #93c5fd;
        font-size: 1.1rem;
    }

    .youth-calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 10px;
        margin-bottom: 25px;
    }

    .youth-calendar-weekday {
        text-align: center;
        font-size: 0.9rem;
        color: #93c5fd;
        padding: 8px;
    }

    .youth-calendar-day {
        text-align: center;
        padding: 12px;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #cbd5e1;
        font-size: 1rem;
    }

    .youth-calendar-day:hover {
        background: rgba(59, 130, 246, 0.2);
    }

    .youth-calendar-today {
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        color: white;
        font-weight: 600;
    }

    .youth-calendar-event {
        position: relative;
        color: #3b82f6;
        font-weight: 600;
    }

    .youth-calendar-event::after {
        content: '';
        position: absolute;
        bottom: 5px;
        left: 50%;
        transform: translateX(-50%);
        width: 6px;
        height: 6px;
        background: #3b82f6;
        border-radius: 50%;
    }

    .youth-calendar-events {
        border-top: 1px solid rgba(59, 130, 246, 0.2);
        padding-top: 25px;
    }

    .youth-calendar-event-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px;
        border-radius: 12px;
        transition: all 0.3s ease;
        cursor: pointer;
        margin-bottom: 8px;
    }

    .youth-calendar-event-item:hover {
        background: rgba(59, 130, 246, 0.1);
    }

    .youth-event-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .youth-announcements {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .youth-announcements-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(59, 130, 246, 0.2);
    }

    .youth-announcements-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
        color: white;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .youth-announcements-count {
        background: rgba(59, 130, 246, 0.2);
        color: #93c5fd;
        padding: 6px 12px;
        border-radius: 15px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .youth-announcement-card {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 20px;
        padding: 25px;
        transition: all 0.3s ease;
        height: 100%;
    }

    .youth-announcement-card:hover {
        border-color: #3b82f6;
        transform: translateY(-5px);
    }

    .announcement-info .youth-announcement-tag {
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
    }

    .announcement-warning .youth-announcement-tag {
        background: linear-gradient(90deg, #f59e0b, #d97706);
    }

    .announcement-success .youth-announcement-tag {
        background: linear-gradient(90deg, #22c55e, #16a34a);
    }

    .announcement-danger .youth-announcement-tag {
        background: linear-gradient(90deg, #dc2626, #b91c1c);
    }

    .youth-announcement-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .youth-announcement-tag {
        color: white;
        padding: 8px 20px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .youth-announcement-icon {
        font-size: 1.1rem;
        margin-right: 8px;
    }

    .youth-announcement-type {
        font-weight: 600;
    }

    .youth-announcement-date {
        font-size: 0.9rem;
        color: #93c5fd;
    }

    .youth-announcement-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: white;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .youth-announcement-content {
        color: #cbd5e1;
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 20px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        max-width: 100%;
    }

    .youth-announcement-expiry {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #f59e0b;
        font-size: 0.9rem;
        margin-bottom: 20px;
        padding: 8px 12px;
        background: rgba(245, 158, 11, 0.1);
        border-radius: 10px;
    }

    .youth-expiry-icon {
        font-size: 1rem;
    }

    .announcement-action {
        background: transparent;
        border: 1px solid rgba(59, 130, 246, 0.3);
        color: white;
        padding: 10px 25px;
        border-radius: 20px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
        width: 100%;
    }

    .announcement-action:hover {
        background: rgba(59, 130, 246, 0.1);
        border-color: #3b82f6;
        transform: translateY(-2px);
    }

    .youth-upcoming-events {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 25px;
        padding: 30px;
        backdrop-filter: blur(10px);
    }

    .youth-upcoming-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 25px;
        color: white;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .youth-upcoming-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .youth-upcoming-item {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 20px;
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 20px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .youth-upcoming-item:hover {
        background: rgba(59, 130, 246, 0.2);
        border-color: #3b82f6;
        transform: translateX(5px);
    }

    .youth-upcoming-date {
        text-align: center;
        min-width: 60px;
    }

    .youth-upcoming-day {
        font-size: 1.8rem;
        font-weight: 700;
        color: #3b82f6;
    }

    .youth-upcoming-month {
        font-size: 0.9rem;
        color: #93c5fd;
    }

    .youth-upcoming-content {
        flex: 1;
    }

    .youth-upcoming-content h4 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: white;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .youth-upcoming-content p {
        font-size: 0.9rem;
        color: #93c5fd;
        margin-bottom: 8px;
    }

    .youth-upcoming-status {
        display: inline-block;
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        color: white;
        padding: 5px 15px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .youth-clubs-section {
        padding: 100px 0;
        width: 100%;
        position: relative;
    }

    .youth-search-box {
        display: flex;
        gap: 15px;
        width: 100%;
        max-width: 450px;
    }

    .youth-search-input {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 30px;
        padding: 16px 30px;
        color: white;
        flex: 1;
        min-width: 0;
        width: 100%;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .youth-search-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);
    }

    .youth-search-btn {
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        border: none;
        color: white;
        width: 55px;
        height: 55px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        flex-shrink: 0;
        font-size: 1.3rem;
    }

    .youth-search-btn:hover {
        transform: scale(1.1) rotate(10deg);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
    }

    .youth-categories {
        display: flex;
        gap: 15px;
        margin-bottom: 50px;
        flex-wrap: wrap;
        width: 100%;
    }

    .youth-category {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1rem;
        white-space: nowrap;
    }

    .youth-category:hover {
        background: rgba(59, 130, 246, 0.2);
        border-color: #3b82f6;
        transform: translateY(-2px);
    }

    .youth-category-active {
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        border-color: transparent;
        transform: translateY(-2px);
    }

    .youth-clubs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 35px;
        width: 100%;
    }

    .youth-club-card {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(6, 182, 212, 0.05));
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 25px;
        padding: 35px;
        transition: all 0.3s ease;
        width: 100%;
        position: relative;
        overflow: hidden;
        min-height: 320px;
        display: flex;
        flex-direction: column;
    }

    .youth-club-card:hover {
        border-color: #3b82f6;
    }

    .youth-club-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .youth-club-category {
        font-size: 1rem;
        color: #93c5fd;
        white-space: nowrap;
    }

    .youth-club-badge {
        font-size: 0.9rem;
        padding: 8px 20px;
        border-radius: 20px;
        font-weight: 600;
        white-space: nowrap;
    }

    .youth-club-badge.youth-recruiting {
        background: rgba(59, 130, 246, 0.2);
        color: #3b82f6;
    }

    .youth-club-badge.youth-active {
        background: rgba(59, 130, 246, 0.2);
        color: #3b82f6;
    }

    .youth-club-title {
        font-size: 1.6rem;
        font-weight: 600;
        margin-bottom: 20px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .youth-club-card p {
        color: #cbd5e1;
        line-height: 1.6;
        margin-bottom: 30px;
        font-size: 1.1rem;
        flex-grow: 1;
    }

    .youth-club-info {
        margin-bottom: 25px;
        width: 100%;
    }

    .youth-club-info .youth-info {
        display: flex;
        justify-content: space-between;
        color: #93c5fd;
        font-size: 1rem;
        flex-wrap: wrap;
        gap: 20px;
    }

    .youth-btn-club {
        width: 100%;
        background: transparent;
        border: 1px solid rgba(59, 130, 246, 0.3);
        color: white;
        padding: 16px;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .youth-btn-club:hover {
        background: rgba(59, 130, 246, 0.1);
        border-color: #3b82f6;
    }

    .youth-card-shine {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            120deg,
            transparent 30%,
            rgba(59, 130, 246, 0.05) 50%,
            transparent 70%
        );
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }

    .youth-card-hover:hover .youth-card-shine {
        transform: translateX(100%);
    }

    .youth-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.95);
        backdrop-filter: blur(10px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .youth-modal.active {
        opacity: 1;
        display: flex;
    }

    .youth-modal-card {
        background: rgba(30, 41, 59, 0.95);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 20px;
        width: 100%;
        max-width: 900px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        backdrop-filter: blur(20px);
        transform: translateY(20px) scale(0.98);
        opacity: 0;
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.4s ease;
        box-shadow: 
            0 25px 50px -12px rgba(0, 0, 0, 0.5),
            0 0 100px rgba(59, 130, 246, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    .youth-modal.active .youth-modal-card {
        transform: translateY(0) scale(1);
        opacity: 1;
    }

    .youth-modal-header {
        background: rgba(15, 23, 42, 0.9);
        border-bottom: 1px solid rgba(59, 130, 246, 0.2);
        padding: 28px 32px;
        border-radius: 20px 20px 0 0;
        position: sticky;
        top: 0;
        z-index: 10;
        backdrop-filter: blur(10px);
        min-width: 0;
    }

    .youth-modal-number {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #3b82f6, #06b6d4);
        color: white;
        width: 56px;
        height: 56px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 24px;
        flex-shrink: 0;
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .youth-modal-title {
        font-size: 24px;
        font-weight: 600;
        color: white;
        line-height: 1.4;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
    }

    .youth-modal-close {
        color: #94a3b8;
        background: rgba(30, 41, 59, 0.8);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        padding: 12px;
        transition: all 0.3s ease;
        flex-shrink: 0;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 20px;
    }

    .youth-modal-close:hover {
        color: white;
        background: rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.4);
        transform: rotate(90deg);
    }

    .youth-modal-body {
        padding: 32px;
        overflow-x: hidden;
    }

    .youth-modal-body span,
    .youth-modal-body p,
    .youth-modal-body div {
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .youth-modal-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 16px;
        margin-bottom: 24px;
        border: 1px solid rgba(59, 130, 246, 0.2);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .youth-modal-image:hover {
        transform: scale(1.02);
        box-shadow: 0 15px 35px rgba(59, 130, 246, 0.4);
    }

    .youth-modal-stats {
        display: flex;
        gap: 24px;
        margin: 24px 0;
        flex-wrap: wrap;
    }

    .youth-modal-stat {
        flex: 1;
        min-width: 120px;
        text-align: center;
        padding: 16px;
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
    }

    .youth-modal-stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 4px;
    }

    .youth-modal-stat-label {
        font-size: 0.9rem;
        color: #93c5fd;
    }

    .youth-modal-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
        min-width: 0;
    }

    .youth-modal-info-item {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
        color: #ffffff;
    }

    .youth-modal-info-item > span {
        min-width: 0;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .youth-modal-info-item:hover {
        background: rgba(59, 130, 246, 0.15);
        border-color: rgba(59, 130, 246, 0.4);
        transform: translateY(-2px);
    }

    .youth-instructor-photo {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid rgba(59, 130, 246, 0.3);
        margin-bottom: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .youth-modal-info-icon {
        font-size: 1.2rem;
        color: #60a5fa;
        min-width: 24px;
    }

    .youth-image-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        backdrop-filter: blur(10px);
        z-index: 10000;
        display: none;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .youth-image-modal.active {
        opacity: 1;
        display: flex;
    }

    .youth-image-modal-content {
        position: relative;
        max-width: 90vw;
        max-height: 90vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .youth-image-modal-img {
        max-width: 100%;
        max-height: 90vh;
        width: auto;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.7);
        animation: youth-image-zoom 0.3s ease;
    }

    @keyframes youth-image-zoom {
        from {
            transform: scale(0.9);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .youth-image-modal-close {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 24px;
        transition: all 0.3s ease;
        z-index: 10001;
    }

    .youth-image-modal-close:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.4);
        transform: rotate(90deg);
    }

    .youth-modal-description {
        color: #ffffff;
        line-height: 1.7;
        margin-bottom: 24px;
        font-size: 1.05rem;
        white-space: pre-wrap;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        background: rgba(31, 41, 55, 0.5);
        padding: 20px;
        border-radius: 12px;
        border-left: 4px solid #3b82f6;
        max-width: 100%;
        overflow-x: hidden;
    }

    .youth-modal-actions {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }

    .youth-modal-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 18px 24px;
        background: linear-gradient(135deg, #3b82f6, #06b6d4);
        color: white;
        font-weight: 600;
        font-size: 16px;
        border-radius: 14px;
        border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        text-align: center;
        min-height: 56px;
    }

    .youth-modal-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.7s ease;
    }

    .youth-modal-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(59, 130, 246, 0.3);
    }

    .youth-modal-btn:hover::before {
        left: 100%;
    }

    .youth-modal-btn-outline {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 18px 24px;
        background: rgba(30, 41, 59, 0.8);
        color: #22d3ee;
        font-weight: 600;
        font-size: 16px;
        border-radius: 14px;
        border: 1px solid rgba(34, 211, 238, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        backdrop-filter: blur(10px);
        text-align: center;
        min-height: 56px;
    }

    .youth-modal-btn-outline:hover {
        transform: translateY(-2px);
        border-color: rgba(34, 211, 238, 0.5);
        background: rgba(30, 41, 59, 0.9);
        box-shadow: 0 8px 25px rgba(34, 211, 238, 0.15);
    }

    .youth-modal-tag {
        display: inline-block;
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        color: white;
        padding: 8px 20px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 16px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: white;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        word-wrap: break-word;
        overflow-wrap: break-word;
        white-space: normal;
    }

    .documents-list {
        background: rgba(15, 23, 42, 0.5);
        border: 1px solid rgba(59, 130, 246, 0.1);
        border-radius: 12px;
        padding: 20px;
    }

    .document-item {
        display: flex;
        align-items: flex-start;
        color: #cbd5e1;
        margin-bottom: 10px;
        padding: 8px 0;
        border-bottom: 1px solid rgba(59, 130, 246, 0.05);
        line-height: 1.5;
    }

    .document-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .documents-grid {
        display: grid;
        gap: 12px;
        margin-bottom: 20px;
    }

    .download-document-card {
        background: rgba(15, 23, 42, 0.5);
        border: 1px solid rgba(59, 130, 246, 0.1);
        border-radius: 12px;
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        transition: all 0.3s ease;
        gap: 16px;
    }

    .download-document-card:hover {
        border-color: rgba(59, 130, 246, 0.3);
        background: rgba(15, 23, 42, 0.7);
    }

    .document-info {
        flex: 1;
        min-width: 0;
    }

    .document-type-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: 1px solid rgba(239, 68, 68, 0.3);
        background: rgba(239, 68, 68, 0.1);
        flex-shrink: 0;
        margin-top: 2px;
    }

    .document-name {
        font-size: 15px;
        font-weight: 500;
        color: white;
        margin-bottom: 4px;
        line-height: 1.4;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
    }

    .document-meta {
        display: flex;
        gap: 16px;
        font-size: 13px;
        color: #94a3b8;
        flex-wrap: wrap;
    }

    .download-action-btn {
        background: rgba(34, 197, 94, 0.1);
        color: #86efac;
        border: 1px solid rgba(34, 197, 94, 0.3);
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        flex-shrink: 0;
        white-space: nowrap;
    }

    .download-action-btn:hover {
        background: rgba(34, 197, 94, 0.2);
        border-color: rgba(34, 197, 94, 0.5);
        color: #bbf7d0;
    }

    .service-features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
        min-width: 0;
    }

    .service-feature-card {
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 16px;
        padding: 24px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
        min-width: 0;
    }

    .service-feature-card > div {
        min-width: 0;
    }

    .service-feature-card > div > div {
        min-width: 0;
    }

    .service-feature-card:hover {
        transform: translateY(-4px);
        border-color: rgba(59, 130, 246, 0.4);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.15);
    }

    .service-feature-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(59, 130, 246, 0.1);
        width: 48px;
        height: 48px;
        border-radius: 12px;
        flex-shrink: 0;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .service-feature-title {
        font-size: 14px;
        font-weight: 600;
        color: #60a5fa;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        min-width: 0;
    }

    .service-feature-text {
        color: #e2e8f0;
        font-size: 16px;
        line-height: 1.5;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
        min-width: 0;
    }

    .youth-calendar-other-month {
        opacity: 0.3;
        color: #666;
    }

    @keyframes modalAppear {
        from {
            opacity: 0;
            transform: translateY(40px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .youth-modal.active .youth-modal-card {
        animation: modalAppear 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    @media (max-width: 1200px) {
        .youth-container-wide {
            max-width: 1200px;
            padding: 0 30px;
        }
        
        .youth-hero-content-wide {
            max-width: 1200px;
            padding: 0 30px;
        }
        
        .youth-main-card-wide-horizontal,
        .youth-carousel-slide {
            width: 115%;
            margin-left: -7.5%;
        }
    }

    @media (max-width: 1024px) {
        .youth-hero-content-wide {
            grid-template-columns: 1fr;
            gap: 40px;
            text-align: center;
            margin-top: 180px;
        }
        
        .youth-hero-text-wide {
            max-width: 100%;
            margin: 0 auto;
        }
        
        .youth-hero-title-wide {
            max-width: 100%;
        }
        
        .youth-hero-visual-wide {
            height: 450px;
            margin-left: 0;
            margin-right: 0;
        }
        
        .youth-photo-carousel-3d-wide {
            max-width: 100%;
            margin: 0 auto;
        }
        
        .youth-main-card-wide-horizontal,
        .youth-carousel-slide {
            width: 100%;
            margin-left: 0;
        }
        
        .youth-hero-top-text-wide {
            min-width: 400px;
        }
        
        .youth-top-title-line-wide {
            font-size: 1.5rem;
        }
        
        .youth-event-card {
            grid-template-columns: 1fr;
        }
        
        .youth-events-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        
        .youth-announcements {
            order: 2;
        }
        
        .youth-events-calendar {
            order: 1;
        }
        
        .youth-upcoming-events {
            order: 3;
        }
    }

    @media (max-width: 768px) {
        .youth-container-wide {
            padding: 0 20px;
        }
        
        .youth-hero-content-wide {
            padding: 0 20px;
        }
        
        .youth-hero {
            min-height: auto;
            padding: 20px 0;
        }
        
        .youth-hero-title-wide {
            font-size: 2.5rem;
        }
        
        .youth-hero-subtitle {
            font-size: 1.1rem;
        }
        
        .youth-hero-visual-wide {
            height: 350px;
        }
        
        .youth-card-overlay-wide {
            padding: 20px;
        }
        
        .youth-card-title {
            font-size: 1.5rem;
        }
        
        .youth-card-desc {
            font-size: 0.9rem;
        }
        
        .youth-section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }
        
        .youth-search-box {
            width: 100%;
            max-width: 100%;
        }
        
        .youth-search-input {
            flex: 1;
            padding: 14px 20px;
        }
        
        .youth-event-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }
        
        .youth-event-timer {
            width: 100%;
            justify-content: flex-start;
        }
        
        .youth-event-actions {
            flex-direction: column;
            width: 100%;
            gap: 15px;
        }
        
        .youth-event-actions .youth-btn-primary {
            width: 100%;
            text-align: center;
            padding: 14px 20px;
        }
        
        .youth-hero-actions {
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }
        
        .youth-btn-primary,
        .youth-btn-outline {
            width: 100%;
            justify-content: center;
            padding: 14px 20px;
        }
        
        .youth-hero-top-text-wide {
            min-width: 300px;
            padding: 15px 25px;
        }
        
        .youth-top-title-line-wide {
            font-size: 1.2rem;
        }
        
        .youth-hero-content-wide {
            margin-top: 150px;
            gap: 40px;
        }
        
        .youth-event-banner,
        .youth-events-section,
        .youth-clubs-section {
            padding: 60px 0;
        }
        
        .youth-section-header {
            margin-bottom: 30px;
        }
        
        .youth-categories {
            margin-bottom: 30px;
            gap: 10px;
        }
        
        .youth-category {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
        
        .youth-clubs-grid {
            gap: 20px;
        }
        
        .youth-club-card {
            padding: 25px;
            min-height: 280px;
        }
        
        .youth-event-card {
            grid-template-columns: 1fr;
        }
        
        .youth-event-image {
            min-height: 300px;
        }
        
        .youth-event-content {
            padding: 30px;
        }
        
        .youth-announcements {
            gap: 20px;
        }
        
        .youth-upcoming-list {
            gap: 15px;
        }
        
        .youth-upcoming-item {
            padding: 15px;
            gap: 15px;
        }

        .youth-modal-info {
            grid-template-columns: 1fr;
        }
        
        .youth-modal-actions {
            flex-direction: column;
        }
        
        .youth-modal-btn,
        .youth-modal-btn-outline {
            width: 100%;
            justify-content: center;
        }
        
        .youth-modal-card {
            max-width: 95%;
            margin: 20px;
        }
        
        .service-features-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .download-document-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
        
        .download-action-btn {
            align-self: flex-start;
        }
        
        .youth-calendar-grid {
            gap: 8px;
            max-width: 100%;
        }
        
        .youth-events-calendar {
            max-width: 100%;
            overflow-x: auto;
        }
        
        .youth-calendar-day {
            padding: 10px;
            font-size: 0.9rem;
            min-width: 0;
        }
            padding: 10px;
            font-size: 0.9rem;
        }
        
        .youth-calendar-weekday {
            font-size: 0.8rem;
            padding: 6px;
        }
        
        .youth-calendar-month {
            font-size: 1.2rem;
        }
    }

    @media (max-width: 480px) {
        .youth-hero-title-wide {
            font-size: 2rem;
        }
        
        .youth-hero-subtitle {
            font-size: 1rem;
        }
        
        .youth-hero-visual-wide {
            height: 280px;
        }
        
        .youth-card-overlay-wide {
            padding: 15px;
        }
        
        .youth-card-title {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        
        .youth-card-desc {
            font-size: 0.85rem;
        }
        
        .youth-clubs-grid {
            grid-template-columns: 1fr;
        }
        
        .youth-timer-item {
            min-width: 60px;
            padding: 8px;
        }
        
        .youth-timer-value {
            font-size: 1.6rem;
        }
        
        .youth-event-info {
            flex-direction: column;
            gap: 15px;
        }
        
        .youth-info-item {
            width: 100%;
            justify-content: center;
            padding: 10px 15px;
        }
        
        .youth-hero-top-text-wide {
            min-width: 250px;
            padding: 10px 15px;
        }
        
        .youth-top-title-line-wide {
            font-size: 1rem;
        }
        
        .youth-hero-content-wide {
            margin-top: 130px;
        }
        
        .youth-event-banner,
        .youth-events-section,
        .youth-clubs-section {
            padding: 40px 0;
        }
        
        .youth-event-content {
            padding: 25px;
            width: 100%;
            overflow-x: hidden;
        }
        
        .youth-event-image {
            min-height: 250px;
        }
        
        .youth-announcements {
            gap: 15px;
        }
        
        .youth-upcoming-list {
            gap: 12px;
        }
        
        .youth-upcoming-item {
            padding: 12px;
            gap: 12px;
        }
        
        .youth-category {
            padding: 8px 15px;
            font-size: 0.8rem;
        }
        
        .youth-modal-header {
            padding: 16px 20px;
        }
        
        .youth-modal-body {
            padding: 20px;
        }
        
        .youth-modal-title {
            font-size: 18px;
        }
        
        .youth-modal-description {
            font-size: 15px;
            padding: 14px;
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
            max-width: 100%;
            overflow-x: hidden;
        }
        
        .youth-modal-close {
            width: 44px;
            height: 44px;
            font-size: 18px;
        }
        
        .youth-calendar-grid {
            gap: 6px;
            max-width: 100%;
        }
        
        .youth-events-calendar {
            max-width: 100%;
            overflow-x: auto;
        }
        
        .youth-calendar-day {
            padding: 8px;
            font-size: 0.85rem;
        }
        
        .youth-calendar-weekday {
            font-size: 0.75rem;
            padding: 4px;
        }
        
        .youth-calendar-month {
            font-size: 1rem;
        }
        
        .youth-calendar-nav {
            width: 30px;
            height: 30px;
            font-size: 0.9rem;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="youth-movement-page">
    <div class="youth-background-particles"></div>
    
    <section class="youth-hero">
        <div class="youth-hero-particles" id="hero-particles"></div>
        <div class="youth-hero-gradient"></div>
        <div class="youth-hero-orb youth-orb-1"></div>
        <div class="youth-hero-orb youth-orb-2"></div>
        <div class="youth-hero-orb youth-orb-3"></div>
        <div class="youth-hero-orb youth-orb-4"></div>
        
        <div class="youth-container-wide">
            <div class="youth-hero-top-center-wide">
                <div class="youth-hero-top-text-wide">
                    <div class="youth-top-title-line-wide youth-title-reveal">
                        {{ \App\Models\PageSection::getValue('youth_movement', 'hero_header', 'hero_line_1', 'Молодежная политика') }}
                    </div>
                    <div class="youth-top-title-line-wide youth-title-reveal" style="animation-delay: 0.1s">
                        {{ \App\Models\PageSection::getValue('youth_movement', 'hero_header', 'hero_line_2', 'Ивенты в колледже') }}
                    </div>
                </div>
            </div>
            
            <div class="youth-hero-content-wide">
                <div class="youth-hero-text-wide">
                    <div class="youth-hero-badge">
                        <span class="youth-badge-dot"></span>
                        <span>
                            <i class="fas fa-rocket" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_rocket', 'Ракета') }}"></i> 
                            {{ \App\Models\PageSection::getValue('youth_movement', 'hero_header', 'hero_badge_text', 'ГОД АКТИВНОСТИ') }} {{ now()->year }}
                        </span>
                    </div>
                    
                    <h1 class="youth-hero-title-wide">
                        <span class="youth-title-line youth-title-reveal" style="animation-delay: 0.3s">
                            {{ \App\Models\PageSection::getValue('youth_movement', 'hero_header', 'hero_main_title_line_1', 'Молодёжный') }}
                        </span>
                        <span class="youth-title-line youth-title-reveal" style="animation-delay: 0.4s">
                            <span class="youth-gradient-text">
                                {{ \App\Models\PageSection::getValue('youth_movement', 'hero_header', 'hero_main_title_line_2', 'ДВИЖ') }}
                            </span>
                        </span>
                    </h1>
                    
                    <div class="youth-hero-subtitle youth-text-reveal" style="animation-delay: 0.6s">
                        <p>{{ \App\Models\PageSection::getValue('youth_movement', 'hero_header', 'hero_subtitle_start', 'Где рождаются') }} <span class="youth-highlight">{{ \App\Models\PageSection::getValue('youth_movement', 'hero_header', 'hero_highlight_1', 'инновации') }}</span>{{ \App\Models\PageSection::getValue('youth_movement', 'hero_header', 'hero_subtitle_middle', ', создаются') }} 
                        <span class="youth-highlight">{{ \App\Models\PageSection::getValue('youth_movement', 'hero_header', 'hero_highlight_2', 'проекты') }}</span>{{ \App\Models\PageSection::getValue('youth_movement', 'hero_header', 'hero_subtitle_end', ' и меняется') }} <span class="youth-highlight">{{ \App\Models\PageSection::getValue('youth_movement', 'hero_header', 'hero_highlight_3', 'будущее') }}</span></p>
                    </div>
                    
                    <div class="youth-hero-actions youth-actions-reveal" style="animation-delay: 1.0s">
                        <button class="youth-btn-primary youth-btn-glow youth-btn-sparkle" onclick="scrollToYouthContent()">
                            <i class="fas fa-play youth-btn-arrow" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_play', 'Воспроизведение') }}"></i>
                            {{ \App\Models\PageSection::getValue('youth_movement', 'hero_header', 'hero_button_text', 'Начать движение') }}
                        </button>
                    </div>
                </div>
                
                <div class="youth-hero-visual-wide">
                    <div class="youth-photo-carousel-3d-wide">
                        <div class="youth-carousel-3d-container-wide">
                            @php
                                function getEventImageUrl($event) {
                                    if (!$event || !$event->image) {
                                        return \App\Models\PageSection::getValue('youth_movement', 'images', 'default_event_image', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=1800&q=80');
                                    }
                                    
                                    if (strpos($event->image, 'http') === 0) {
                                        return $event->image;
                                    }
                                    
                                    if (file_exists(public_path('uploads/' . $event->image))) {
                                        return asset('uploads/' . $event->image);
                                    } elseif (file_exists(storage_path('app/public/' . $event->image))) {
                                        return asset('storage/' . $event->image);
                                    }
                                    
                                    return \App\Models\PageSection::getValue('youth_movement', 'images', 'default_event_image', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=1800&q=80');
                                }
                                
                                function getClubImageUrl($club) {
                                    if (!$club || !$club->image) {
                                        return \App\Models\PageSection::getValue('youth_movement', 'images', 'default_club_image', 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1800&q=80');
                                    }
                                    
                                    if (strpos($club->image, 'http') === 0) {
                                        return $club->image;
                                    }
                                    
                                    if (file_exists(public_path('uploads/' . $club->image))) {
                                        return asset('uploads/' . $club->image);
                                    } elseif (file_exists(storage_path('app/public/' . $club->image))) {
                                        return asset('storage/' . $club->image);
                                    }
                                    
                                    return \App\Models\PageSection::getValue('youth_movement', 'images', 'default_club_image', 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1800&q=80');
                                }
                                
                                $featuredEventImageUrl = getEventImageUrl($featuredEvent);
                            @endphp
                            
                            @if($featuredEvent)
                                <div class="youth-main-card-wide-horizontal youth-card-3d youth-carousel-slide youth-active carousel-card-clickable" 
                                     style="background-image: linear-gradient(rgba(15, 23, 42, 0.5), rgba(15, 23, 42, 0.5)), url('{{ $featuredEventImageUrl }}');"
                                     onclick="openImageModal('{{ $featuredEventImageUrl }}')">
                                    <div class="youth-card-overlay-wide">
                                        <div class="youth-card-badge">
                                            <i class="fas fa-fire" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_fire', 'Огонь') }}"></i> 
                                            {{ \App\Models\PageSection::getValue('youth_movement', 'carousel_events', 'carousel_badge_week', 'СОБЫТИЕ НЕДЕЛИ') }}
                                        </div>
                                        <h3 class="youth-card-title">{{ $featuredEvent->title ?? \App\Models\PageSection::getValue('youth_movement', 'demo_fallback', 'demo_carousel_title_1', 'Ночь науки 2025') }}</h3>
                                        <p class="youth-card-desc">{{ $featuredEvent->event_date ? \Carbon\Carbon::parse($featuredEvent->event_date)->setTimezone(config('app.timezone'))->locale('ru')->translatedFormat('d F • H:i') : \App\Models\PageSection::getValue('youth_movement', 'carousel_events', 'event_date_unknown', 'Дата уточняется') }} • {{ $featuredEvent->location ?? \App\Models\PageSection::getValue('youth_movement', 'carousel_events', 'event_location_default', 'Актовый зал') }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="youth-main-card-wide-horizontal youth-card-3d youth-carousel-slide youth-active carousel-card-clickable" 
                                     style="background-image: linear-gradient(rgba(15, 23, 42, 0.5), rgba(15, 23, 42, 0.5)), url('{{ \App\Models\PageSection::getValue('youth_movement', 'images', 'demo_event_image_1', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=1800&q=80') }}');"
                                     onclick="openImageModal('{{ \App\Models\PageSection::getValue('youth_movement', 'images', 'demo_event_image_1', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=1800&q=80') }}')">
                                    <div class="youth-card-overlay-wide">
                                        <div class="youth-card-badge">
                                            <i class="fas fa-fire" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_fire', 'Огонь') }}"></i> 
                                            {{ \App\Models\PageSection::getValue('youth_movement', 'carousel_events', 'carousel_badge_week', 'СОБЫТИЕ НЕДЕЛИ') }}
                                        </div>
                                        <h3 class="youth-card-title">{{ \App\Models\PageSection::getValue('youth_movement', 'demo_fallback', 'demo_carousel_title_1', 'Ночь науки 2025') }}</h3>
                                        <p class="youth-card-desc">{{ \App\Models\PageSection::getValue('youth_movement', 'demo_fallback', 'demo_carousel_desc_1', '25 ноября • 18:00 • Актовый зал') }}</p>
                                    </div>
                                </div>
                            @endif
                            
                            @if(isset($upcomingEvents) && $upcomingEvents->count() > 0)
                                @foreach($upcomingEvents->take(2) as $index => $event)
                                    @php
                                        $eventImageUrl = getEventImageUrl($event);
                                    @endphp
                                    
                                    <div class="youth-main-card-wide-horizontal youth-card-3d youth-carousel-slide @if($loop->first && !$featuredEvent) youth-active @endif carousel-card-clickable" 
                                         style="background-image: linear-gradient(rgba(15, 23, 42, 0.5), rgba(15, 23, 42, 0.5)), url('{{ $eventImageUrl }}');"
                                         onclick="openImageModal('{{ $eventImageUrl }}')">
                                        <div class="youth-card-overlay-wide">
                                            <div class="youth-card-badge" style="background: linear-gradient(90deg, #22c55e, #16a34a);">
                                                <i class="fas {{ $event->type == 'week_event' ? 'fa-fire' : 'fa-calendar-alt' }}" 
                                                   title="{{ $event->type == 'week_event' ? \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_fire', 'Огонь') : \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_calendar', 'Календарь') }}"></i> 
                                                {{ $event->type == 'week_event' ? \App\Models\PageSection::getValue('youth_movement', 'carousel_events', 'carousel_badge_week', 'СОБЫТИЕ НЕДЕЛИ') : \App\Models\PageSection::getValue('youth_movement', 'carousel_events', 'carousel_badge_upcoming', 'БЛИЖАЙШЕЕ') }}
                                            </div>
                                            <h3 class="youth-card-title">{{ Str::limit($event->title, 40) }}</h3>
                                            <p class="youth-card-desc">{{ $event->event_date ? \Carbon\Carbon::parse($event->event_date)->setTimezone(config('app.timezone'))->locale('ru')->translatedFormat('d F • H:i') : \App\Models\PageSection::getValue('youth_movement', 'carousel_events', 'event_date_unknown', 'Дата уточняется') }} • {{ $event->location ?? \App\Models\PageSection::getValue('youth_movement', 'carousel_events', 'event_place_unknown', 'Место уточняется') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="youth-main-card-wide-horizontal youth-card-3d youth-carousel-slide carousel-card-clickable" 
                                     style="background-image: linear-gradient(rgba(15, 23, 42, 0.5), rgba(15, 23, 42, 0.5)), url('{{ \App\Models\PageSection::getValue('youth_movement', 'images', 'demo_event_image_2', 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1800&q=80') }}');"
                                     onclick="openImageModal('{{ \App\Models\PageSection::getValue('youth_movement', 'images', 'demo_event_image_2', 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1800&q=80') }}')">
                                    <div class="youth-card-overlay-wide">
                                        <div class="youth-card-badge" style="background: linear-gradient(90deg, #22c55e, #16a34a);">
                                            <i class="fas fa-calendar-alt" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_calendar', 'Календарь') }}"></i> 
                                            {{ \App\Models\PageSection::getValue('youth_movement', 'carousel_events', 'carousel_badge_upcoming', 'БЛИЖАЙШЕЕ') }}
                                        </div>
                                        <h3 class="youth-card-title">{{ \App\Models\PageSection::getValue('youth_movement', 'demo_fallback', 'demo_carousel_title_2', 'Кибертурнир CS:GO') }}</h3>
                                        <p class="youth-card-desc">{{ \App\Models\PageSection::getValue('youth_movement', 'demo_fallback', 'demo_carousel_desc_2', '14 ноября • 18:00 • Компьютерный класс') }}</p>
                                    </div>
                                </div>
                                
                                <div class="youth-main-card-wide-horizontal youth-card-3d youth-carousel-slide" 
                                     style="background-image: linear-gradient(rgba(15, 23, 42, 0.5), rgba(15, 23, 42, 0.5)), url('{{ \App\Models\PageSection::getValue('youth_movement', 'images', 'demo_event_image_3', 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1800&q=80') }}')">
                                    <div class="youth-card-overlay-wide">
                                        <div class="youth-card-badge" style="background: linear-gradient(90deg, #dc2626, #b91c1c);">
                                            <i class="fas fa-calendar-alt" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_calendar', 'Календарь') }}"></i> 
                                            {{ \App\Models\PageSection::getValue('youth_movement', 'carousel_events', 'carousel_badge_upcoming', 'БЛИЖАЙШЕЕ') }}
                                        </div>
                                        <h3 class="youth-card-title">{{ \App\Models\PageSection::getValue('youth_movement', 'demo_fallback', 'demo_carousel_title_3', 'Театральный вечер') }}</h3>
                                        <p class="youth-card-desc">{{ \App\Models\PageSection::getValue('youth_movement', 'demo_fallback', 'demo_carousel_desc_3', '20 ноября • 19:00 • Актовый зал') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <div class="youth-carousel-nav">
                            <button class="youth-nav-btn youth-nav-prev" title="{{ \App\Models\PageSection::getValue('youth_movement', 'carousel_events', 'carousel_nav_prev', 'Предыдущее') }}">
                                <i class="fas fa-chevron-left" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_chevron_left', 'Стрелка влево') }}"></i>
                            </button>
                            <div class="youth-carousel-dots">
                                @for($i = 0; $i < min(3, ($featuredEvent ? 1 : 0) + (isset($upcomingEvents) ? $upcomingEvents->count() : 0) + 2); $i++)
                                    <span class="youth-carousel-dot @if($i == 0) youth-active @endif"></span>
                                @endfor
                            </div>
                            <button class="youth-nav-btn youth-nav-next" title="{{ \App\Models\PageSection::getValue('youth_movement', 'carousel_events', 'carousel_nav_next', 'Следующее') }}">
                                <i class="fas fa-chevron-right" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_chevron_right', 'Стрелка вправо') }}"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="youth-event-banner">
        <div class="youth-container">
            <div class="youth-event-card youth-card-hover">
                <div class="youth-event-image">
                    @php
                        function getFeaturedEventImageUrlForBanner($event) {
                            if (!$event || !$event->image) {
                                return \App\Models\PageSection::getValue('youth_movement', 'images', 'featured_event_image', 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');
                            }
                            
                            if (strpos($event->image, 'http') === 0) {
                                return $event->image;
                            }
                            
                            if (file_exists(public_path('uploads/' . $event->image))) {
                                return asset('uploads/' . $event->image);
                            } elseif (file_exists(storage_path('app/public/' . $event->image))) {
                                return asset('storage/' . $event->image);
                            }
                            
                            return \App\Models\PageSection::getValue('youth_movement', 'images', 'featured_event_image', 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');
                        }
                        
                        $featuredEventMainImageUrl = getFeaturedEventImageUrlForBanner($featuredEvent);
                    @endphp
                    
                    <img src="{{ $featuredEventMainImageUrl }}" 
                         alt="{{ $featuredEvent ? $featuredEvent->title : \App\Models\PageSection::getValue('youth_movement', 'featured_event', 'default_event_title', 'НОЧЬ НАУКИ') }}" 
                         class="youth-event-img"
                         onerror="this.src='{{ \App\Models\PageSection::getValue('youth_movement', 'images', 'featured_event_image', 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80') }}'">
                    <div class="youth-event-badge">
                        <i class="fas fa-fire" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_fire', 'Огонь') }}"></i> 
                        {{ \App\Models\PageSection::getValue('youth_movement', 'featured_event', 'featured_badge', 'СОБЫТИЕ') }} {{ now()->year }}
                    </div>
                </div>
                <div class="youth-event-content">
                    <div class="youth-event-header">
                        <h2 class="youth-text-gradient">
                            @if($featuredEvent)
                                {{ $featuredEvent->title }}
                            @else
                                {{ \App\Models\PageSection::getValue('youth_movement', 'featured_event', 'default_event_title', 'НОЧЬ НАУКИ') }} {{ now()->year }}
                            @endif
                        </h2>
                        

                    </div>
                    <div class="youth-event-info">
                        @if($featuredEvent && $featuredEvent->event_date)
                        <div class="youth-info-item youth-info-glow">
                            <span class="youth-info-icon">
                                <i class="fas fa-calendar-alt" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_calendar', 'Календарь') }}"></i>
                            </span>
                            <span class="youth-info-text">
                                {{ \Carbon\Carbon::parse($featuredEvent->event_date)->setTimezone(config('app.timezone'))->locale('ru')->translatedFormat('d F, H:i') }} • {{ now()->year }}
                            </span>
                        </div>
                        @endif
                        
                        <div class="youth-info-item youth-info-glow">
                            <span class="youth-info-icon">
                                <i class="fas fa-map-marker-alt" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_map_marker', 'Метка на карте') }}"></i>
                            </span>
                            <span class="youth-info-text">
                                @if($featuredEvent && $featuredEvent->location)
                                    {{ $featuredEvent->location }}
                                @else
                                    {{ \App\Models\PageSection::getValue('youth_movement', 'carousel_events', 'event_location_default', 'Актовый зал') }}
                                @endif
                            </span>
                        </div>
                        
                        <div class="youth-info-item youth-info-glow">
                            <span class="youth-info-icon">
                                <i class="fas fa-users" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_users', 'Пользователи') }}"></i>
                            </span>
                            <span class="youth-info-text youth-counter" data-count="{{ $featuredEvent && $featuredEvent->participants_count ? $featuredEvent->participants_count : \App\Models\PageSection::getValue('youth_movement', 'demo_fallback', 'demo_featured_participants', '156') }}">0</span>
                        </div>
                        
                        @if($featuredEvent && $featuredEvent->organizer)
                        <div class="youth-info-item youth-info-glow">
                            <span class="youth-info-icon">
                                <i class="fas fa-user" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_user', 'Пользователь') }}"></i>
                            </span>
                            <span class="youth-info-text">{{ $featuredEvent->organizer }}</span>
                        </div>
                        @endif
                    </div>
                    <p class="youth-event-description">
                        @if($featuredEvent)
                            {{ $featuredEvent->short_description ?? $featuredEvent->description ?? \App\Models\PageSection::getValue('youth_movement', 'featured_event', 'default_event_description', 'Главное событие года! Присоединяйтесь к самому ожидаемому мероприятию сезона.') }}
                        @else
                            {{ \App\Models\PageSection::getValue('youth_movement', 'featured_event', 'default_event_description', 'Главное научное событие 2025 года! Эксперименты, лекции от ведущих ученых, интерактивные зоны и научные батлы. Стань частью технологической революции!') }}
                        @endif
                    </p>
                    <div class="youth-event-actions">
                        <button class="youth-btn-outline youth-btn-hover" onclick="openEventModal('{{ $featuredEvent ? $featuredEvent->id : 0 }}')">
                            <i class="fas fa-info-circle youth-btn-icon" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_info', 'Информация') }}"></i>
                            {{ \App\Models\PageSection::getValue('youth_movement', 'featured_event', 'event_button_text', 'Подробнее о событии') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="youth-events-section" id="youth-events">
        <div class="youth-container">
            <div class="youth-section-header">
                <h2 class="youth-section-title">
                    {{ \App\Models\PageSection::getValue('youth_movement', 'calendar', 'calendar_title', 'Календарь событий') }} {{ now()->year }}
                </h2>
                <div class="youth-calendar-badge">
                    <div class="youth-calendar-icon">
                        <i class="fas fa-calendar-alt" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_calendar', 'Календарь') }}"></i>
                    </div>
                    <span id="current-month">{{ $monthName ?? now()->locale('ru')->translatedFormat('F Y') }}</span>
                </div>
            </div>

            <div class="youth-events-grid">
                <div class="youth-events-calendar">
                    <div class="youth-calendar-header">
                        <button class="youth-calendar-nav" onclick="changeMonth(-1)" title="{{ \App\Models\PageSection::getValue('youth_movement', 'carousel_events', 'carousel_nav_prev', 'Предыдущее') }}">
                            <i class="fas fa-chevron-left" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_chevron_left', 'Стрелка влево') }}"></i>
                        </button>
                        <div class="youth-calendar-month" id="calendar-month">{{ $monthName ?? now()->locale('ru')->translatedFormat('F Y') }}</div>
                        <button class="youth-calendar-nav" onclick="changeMonth(1)" title="{{ \App\Models\PageSection::getValue('youth_movement', 'carousel_events', 'carousel_nav_next', 'Следующее') }}">
                            <i class="fas fa-chevron-right" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_chevron_right', 'Стрелка вправо') }}"></i>
                        </button>
                    </div>
                    <div class="youth-calendar-grid" id="calendar-grid">
                        @php
                            $weekdays = explode(',', \App\Models\PageSection::getValue('youth_movement', 'calendar', 'weekdays', 'Пн,Вт,Ср,Чт,Пт,Сб,Вс'));
                        @endphp
                        @foreach($weekdays as $weekday)
                            <div class="youth-calendar-weekday">{{ trim($weekday) }}</div>
                        @endforeach
                    </div>
                    <div class="youth-calendar-events">
                        @if(isset($upcomingEvents) && $upcomingEvents->count() > 0)
                            @foreach($upcomingEvents->take(3) as $event)
                            <div class="youth-calendar-event-item" onclick="openEventModal('{{ $event->id }}')">
                                <div class="youth-event-dot" style="background: linear-gradient(90deg, #3b82f6, #06b6d4);"></div>
                                <span>{{ \Carbon\Carbon::parse($event->event_date)->setTimezone(config('app.timezone'))->locale('ru')->translatedFormat('d F') }}: {{ Str::limit($event->title, 30) }}</span>
                            </div>
                            @endforeach
                        @else
                            <div class="youth-calendar-event-item" onclick="openEventModal('0')">
                                <div class="youth-event-dot" style="background: linear-gradient(90deg, #3b82f6, #06b6d4);"></div>
                                <span>{{ \App\Models\PageSection::getValue('youth_movement', 'demo_fallback', 'demo_calendar_event_1', '25 ноября: Ночь науки') }}</span>
                            </div>
                            <div class="youth-calendar-event-item" onclick="openEventModal('0')">
                                <div class="youth-event-dot" style="background: linear-gradient(90deg, #dc2626, #b91c1c);"></div>
                                <span>{{ \App\Models\PageSection::getValue('youth_movement', 'demo_fallback', 'demo_calendar_event_2', '14 ноября: Кибертурнир') }}</span>
                            </div>
                            <div class="youth-calendar-event-item" onclick="openEventModal('0')">
                                <div class="youth-event-dot" style="background: linear-gradient(90deg, #22c55e, #16a34a);"></div>
                                <span>{{ \App\Models\PageSection::getValue('youth_movement', 'demo_fallback', 'demo_calendar_event_3', '20 ноября: Театральный вечер') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="youth-announcements">
                    <div class="youth-announcements-header">
                        <h3 class="youth-announcements-title">
                            <i class="fas fa-bullhorn" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_bullhorn', 'Громкоговоритель') }}"></i> 
                            {{ \App\Models\PageSection::getValue('youth_movement', 'announcements', 'announcements_title', 'Объявления') }}
                        </h3>
                        <span class="youth-announcements-count">
                            {{ isset($announcements) ? $announcements->count() : 0 }} 
                            {{ \App\Models\PageSection::getValue('youth_movement', 'announcements', 'announcements_count_suffix', 'активных') }}
                        </span>
                    </div>
                    
                    @if(isset($announcements) && $announcements->count() > 0)
                        @foreach($announcements as $announcement)
                        <div class="youth-announcement-card youth-card-hover announcement-{{ $announcement->type }}" onclick="openAnnouncementModal('{{ $announcement->id }}')">
                            <div class="youth-announcement-header">
                                <div class="youth-announcement-tag">
                                    <span class="youth-announcement-icon">
                                        @switch($announcement->type)
                                            @case('info') 
                                                <i class="fas fa-bullhorn" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_bullhorn', 'Громкоговоритель') }}"></i> 
                                                @break
                                            @case('warning') 
                                                <i class="fas fa-exclamation-triangle" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_exclamation', 'Восклицание') }}"></i> 
                                                @break
                                            @case('success') 
                                                <i class="fas fa-check-circle" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_check', 'Галочка') }}"></i> 
                                                @break
                                            @case('danger') 
                                                <i class="fas fa-fire" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_fire', 'Огонь') }}"></i> 
                                                @break
                                            @default 
                                                <i class="fas fa-bullhorn" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_bullhorn', 'Громкоговоритель') }}"></i>
                                        @endswitch
                                    </span>
                                    <span class="youth-announcement-type">
                                        @switch($announcement->type)
                                            @case('info') {{ \App\Models\PageSection::getValue('youth_movement', 'announcements', 'announcement_type_info', 'ИНФОРМАЦИЯ') }} @break
                                            @case('warning') {{ \App\Models\PageSection::getValue('youth_movement', 'announcements', 'announcement_type_warning', 'ВНИМАНИЕ') }} @break
                                            @case('success') {{ \App\Models\PageSection::getValue('youth_movement', 'announcements', 'announcement_type_success', 'УСПЕХ') }} @break
                                            @case('danger') {{ \App\Models\PageSection::getValue('youth_movement', 'announcements', 'announcement_type_danger', 'ВАЖНО') }} @break
                                            @default {{ \App\Models\PageSection::getValue('youth_movement', 'announcements', 'announcement_type_default', 'ОБЪЯВЛЕНИЕ') }}
                                        @endswitch
                                    </span>
                                </div>
                                <div class="youth-announcement-date">{{ \Carbon\Carbon::parse($announcement->created_at)->setTimezone(config('app.timezone'))->format('d.m.Y') }}</div>
                            </div>
                            <h3 class="youth-announcement-title">{{ $announcement->translated_title ?? $announcement->title }}</h3>
                            <p class="youth-announcement-content">{{ Str::limit($announcement->translated_content ?? $announcement->content, 150) }}</p>
                        </div>
                        @endforeach
                    @else
                        <div class="youth-announcement-card youth-card-hover">
                            <div class="youth-announcement-header">
                                <div class="youth-announcement-tag">
                                    <i class="fas fa-bullhorn" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_bullhorn', 'Громкоговоритель') }}"></i> 
                                    {{ \App\Models\PageSection::getValue('youth_movement', 'announcements', 'announcement_type_info', 'ИНФОРМАЦИЯ') }}
                                </div>
                                <div class="youth-announcement-date">{{ now()->format('d.m.Y') }}</div>
                            </div>
                            <h3 class="youth-announcement-title">
                                {{ \App\Models\PageSection::getValue('youth_movement', 'announcements', 'default_announcement_title', 'Нет активных объявлений') }}
                            </h3>
                            <p class="youth-announcement-content">
                                {{ \App\Models\PageSection::getValue('youth_movement', 'announcements', 'default_announcement_content', 'Здесь будут появляться важные объявления для студентов.') }}
                            </p>
                        </div>
                        
                        <div class="youth-announcement-card youth-card-hover">
                            <div class="youth-announcement-header">
                                <div class="youth-announcement-tag" style="background: linear-gradient(90deg, #22c55e, #16a34a);">
                                    <i class="fas fa-check-circle" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_check', 'Галочка') }}"></i> 
                                    {{ \App\Models\PageSection::getValue('youth_movement', 'announcements', 'announcement_type_success', 'УСПЕХ') }}
                                </div>
                                <div class="youth-announcement-date">{{ now()->format('d.m.Y') }}</div>
                            </div>
                            <h3 class="youth-announcement-title">
                                {{ \App\Models\PageSection::getValue('youth_movement', 'announcements', 'add_announcement_title', 'Добавьте первое объявление') }}
                            </h3>
                            <p class="youth-announcement-content">
                                {{ \App\Models\PageSection::getValue('youth_movement', 'announcements', 'add_announcement_content', 'Используйте админ-панель для создания объявлений.') }}
                            </p>
                        </div>
                    @endif
                </div>

                <div class="youth-upcoming-events">
                    <h3 class="youth-upcoming-title">
                        <i class="fas fa-calendar" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_calendar', 'Календарь') }}"></i> 
                        {{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'upcoming_title', 'Ближайшие события') }} {{ now()->year }}
                    </h3>
                    <div class="youth-upcoming-list">
                        @if(isset($upcomingEvents) && $upcomingEvents->count() > 0)
                            @foreach($upcomingEvents as $event)
                            <div class="youth-upcoming-item youth-card-hover" onclick="openEventModal('{{ $event->id }}')">
                                <div class="youth-upcoming-date">
                                    <div class="youth-upcoming-day">{{ \Carbon\Carbon::parse($event->event_date)->setTimezone(config('app.timezone'))->format('d') }}</div>
                                    <div class="youth-upcoming-month">
                                        @php
                                            $monthNamesShort = explode(',', \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'month_names_short', 'Янв,Фев,Мар,Апр,Май,Июн,Июл,Авг,Сен,Окт,Ноя,Дек'));
                                            $monthIndex = \Carbon\Carbon::parse($event->event_date)->month - 1;
                                            $monthShort = $monthNamesShort[$monthIndex] ?? \Carbon\Carbon::parse($event->event_date)->locale('ru')->translatedFormat('M');
                                        @endphp
                                        {{ $monthShort }}
                                    </div>
                                </div>
                                <div class="youth-upcoming-content">
                                    <h4>{{ Str::limit($event->title, 25) }}</h4>
                                    <p>{{ \Carbon\Carbon::parse($event->event_date)->setTimezone(config('app.timezone'))->format('H:i') }} • {{ $event->location ? Str::limit($event->location, 20) : \App\Models\PageSection::getValue('youth_movement', 'carousel_events', 'event_place_unknown', 'Место уточняется') }}</p>
                                    <div class="youth-upcoming-status">
                                        @if($event->type == 'week_event')
                                            {{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'status_hot', 'ГОРЯЧЕЕ') }}
                                        @elseif($event->registration_link)
                                            {{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'status_registration', 'РЕГИСТРАЦИЯ') }}
                                        @else
                                            {{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'status_waiting', 'ОЖИДАЕТСЯ') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="youth-upcoming-item youth-card-hover" onclick="openEventModal('0')">
                                <div class="youth-upcoming-date">
                                    <div class="youth-upcoming-day">14</div>
                                    <div class="youth-upcoming-month">Ноя</div>
                                </div>
                                <div class="youth-upcoming-content">
                                    <h4>{{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'demo_event_1_title', 'Киберспортивный турнир') }}</h4>
                                    <p>{{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'demo_event_1_time', '18:00') }} • {{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'demo_event_1_location', 'Компьютерный класс') }}</p>
                                    <div class="youth-upcoming-status">{{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'status_waiting', 'ОЖИДАЕТСЯ') }}</div>
                                </div>
                            </div>

                            <div class="youth-upcoming-item youth-card-hover" onclick="openEventModal('0')">
                                <div class="youth-upcoming-date">
                                    <div class="youth-upcoming-day">20</div>
                                    <div class="youth-upcoming-month">Ноя</div>
                                </div>
                                <div class="youth-upcoming-content">
                                    <h4>{{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'demo_event_2_title', 'Театральный вечер') }}</h4>
                                    <p>{{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'demo_event_2_time', '19:00') }} • {{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'demo_event_2_location', 'Актовый зал') }}</p>
                                    <div class="youth-upcoming-status" style="background: linear-gradient(90deg, #22c55e, #16a34a);">{{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'status_waiting', 'ОЖИДАЕТСЯ') }}</div>
                                </div>
                            </div>

                            <div class="youth-upcoming-item youth-card-hover" onclick="openEventModal('0')">
                                <div class="youth-upcoming-date">
                                    <div class="youth-upcoming-day">25</div>
                                    <div class="youth-upcoming-month">Ноя</div>
                                </div>
                                <div class="youth-upcoming-content">
                                    <h4>{{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'demo_event_3_title', 'Ночь науки') }}</h4>
                                    <p>{{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'demo_event_3_time', '18:00') }} • {{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'demo_event_3_location', 'Главный корпус') }}</p>
                                    <div class="youth-upcoming-status" style="background: linear-gradient(90deg, #3b82f6, #06b6d4);">{{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'status_waiting', 'ОЖИДАЕТСЯ') }}</div>
                                </div>
                            </div>

                            <div class="youth-upcoming-item youth-card-hover" onclick="openEventModal('0')">
                                <div class="youth-upcoming-date">
                                    <div class="youth-upcoming-day">30</div>
                                    <div class="youth-upcoming-month">Ноя</div>
                                </div>
                                <div class="youth-upcoming-content">
                                    <h4>{{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'demo_event_4_title', 'AI Хакатон') }}</h4>
                                    <p>{{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'demo_event_4_time', '16:00') }} • {{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'demo_event_4_location', 'IT-центр') }}</p>
                                    <div class="youth-upcoming-status" style="background: linear-gradient(90deg, #06b6d4, #0891b2);">{{ \App\Models\PageSection::getValue('youth_movement', 'upcoming_events', 'status_waiting', 'ОЖИДАЕТСЯ') }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="youth-clubs-section" id="youth-clubs">
        <div class="youth-container">
            <div class="youth-section-header">
                <h2 class="youth-section-title">
                    {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'directions_title', 'Направления') }} {{ now()->year }}
                </h2>
                <div class="youth-search-box">
                    <input type="text" 
                           placeholder="{{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'search_placeholder', 'Найти направление...') }}" 
                           class="youth-search-input">
                    <button class="youth-search-btn youth-btn-glow" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_search', 'Поиск') }}">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="youth-categories">
                <button class="youth-category youth-category-active" data-category="all">
                    {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'category_all', 'Все') }}
                </button>
                <button class="youth-category" data-category="technology">
                    <i class="fas fa-laptop-code"></i> 
                    {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'category_technology', 'Технологии') }}
                </button>
                <button class="youth-category" data-category="art">
                    <i class="fas fa-palette"></i> 
                    {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'category_art', 'Творчество') }}
                </button>
                <button class="youth-category" data-category="sport">
                    <i class="fas fa-running"></i> 
                    {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'category_sport', 'Спорт') }}
                </button>
                <button class="youth-category" data-category="science">
                    <i class="fas fa-flask"></i> 
                    {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'category_science', 'Наука') }}
                </button>
                <button class="youth-category" data-category="music">
                    <i class="fas fa-music"></i> 
                    {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'category_music', 'Музыка') }}
                </button>
            </div>

            <div class="youth-clubs-grid">
                @if(isset($clubs) && $clubs->count() > 0)
                    @foreach($clubs as $index => $club)
                    <div class="youth-club-card youth-card-hover" data-category="{{ $club->category }}">
                        <div class="youth-club-header">
                            <span class="youth-club-category">
                                @switch($club->category)
                                    @case('sport') <i class="fas fa-basketball-ball"></i> {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'category_sport', 'Спорт') }} @break
                                    @case('art') <i class="fas fa-palette"></i> {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'category_art', 'Искусство') }} @break
                                    @case('science') <i class="fas fa-flask"></i> {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'category_science', 'Наука') }} @break
                                    @case('technology') <i class="fas fa-laptop-code"></i> {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'category_technology', 'Технологии') }} @break
                                    @case('music') <i class="fas fa-music"></i> {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'category_music', 'Музыка') }} @break
                                    @case('dance') <i class="fas fa-child"></i> {{ $club->category }} @break
                                    @case('theater') <i class="fas fa-theater-masks"></i> {{ $club->category }} @break
                                    @case('volunteer') <i class="fas fa-hands-helping"></i> {{ $club->category }} @break
                                    @default <i class="fas fa-tag"></i> {{ $club->category }}
                                @endswitch
                            </span>
                            <span class="youth-club-badge {{ $club->is_recruiting ? 'youth-recruiting' : 'youth-active' }}">
                                {{ $club->is_recruiting ? \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'badge_recruiting', 'НАБОР') : \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'badge_active', 'АКТИВНО') }}
                            </span>
                        </div>
                        <h3 class="youth-club-title">{{ $club->translated_name ?? $club->name }}</h3>
                        <p>{{ Str::limit($club->translated_short_description ?? $club->short_description ?? $club->description, 120) }}</p>
                        <div class="youth-club-info">
                            <div class="youth-info">
                                <span class="youth-info-glow">
                                    <i class="fas fa-users" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_users', 'Пользователи') }}"></i> 
                                    {{ $club->current_participants }}{{ $club->max_participants ? '/' . $club->max_participants : '' }}
                                </span>
                                @if($club->translated_schedule ?? $club->schedule)
                                <span class="youth-info-glow">
                                    <i class="fas fa-calendar-alt" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_calendar', 'Календарь') }}"></i> 
                                    {{ Str::limit($club->translated_schedule ?? $club->schedule, 15) }}
                                </span>
                                @endif
                                @if($club->price > 0)
                                <span class="youth-info-glow">
                                    <i class="fas fa-money-bill-wave" title="{{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'club_info_price', 'Стоимость') }}"></i> 
                                    {{ number_format($club->price, 0, '.', ' ') }} ₸
                                </span>
                                @else
                                <span class="youth-info-glow" style="color: #22c55e;">
                                    <i class="fas fa-money-bill-wave" title="{{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'club_info_price', 'Стоимость') }}"></i> 
                                    {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'club_free_price', 'Бесплатно') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <button class="youth-btn-club youth-btn-hover" onclick="openClubModal('{{ $club->id }}', '{{ $index + 1 }}')">
                            {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'club_button_text', 'Подробнее') }} 
                            <i class="fas fa-arrow-right" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_arrow_right', 'Стрелка вправо') }}"></i>
                        </button>
                        <div class="youth-card-shine"></div>
                    </div>
                    @endforeach
                @else
                    @php
                        $demoClubs = [
                            ['id' => 0, 'index' => 1, 'category' => 'technology', 'name' => \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'demo_club_1_title', 'AI Лаборатория'), 'desc' => \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'demo_club_1_desc', 'Исследования в области искусственного интеллекта, машинного обучения и нейросетей.'), 'participants' => '30', 'schedule' => \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'demo_club_1_schedule', 'Пн/Ср 19:00')],
                            ['id' => 0, 'index' => 2, 'category' => 'art', 'name' => \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'demo_club_2_title', 'Медиастудия'), 'desc' => \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'demo_club_2_desc', 'Создание контента, видеопроизводство, блогинг и SMM для социальных сетей.'), 'participants' => '25', 'schedule' => \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'demo_club_2_schedule', 'Вт/Чт 18:00')],
                            ['id' => 0, 'index' => 3, 'category' => 'sport', 'name' => \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'demo_club_3_title', 'Уличные виды'), 'desc' => \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'demo_club_3_desc', 'Воркаут, скейтбординг, баскетбол и другие уличные спортивные направления.'), 'participants' => '40', 'schedule' => \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'demo_club_3_schedule', 'Ежедневно')],
                            ['id' => 0, 'index' => 4, 'category' => 'science', 'name' => \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'demo_club_4_title', 'Исследовательский клуб'), 'desc' => \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'demo_club_4_desc', 'Научные проекты, публикации и участие в конференциях по различным дисциплинам.'), 'participants' => '35', 'schedule' => \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'demo_club_4_schedule', 'Пн/Пт 17:00')]
                        ];
                    @endphp
                    @foreach($demoClubs as $club)
                    <div class="youth-club-card youth-card-hover" data-category="{{ $club['category'] }}">
                        <div class="youth-club-header">
                            <span class="youth-club-category">
                                @switch($club['category'])
                                    @case('sport') <i class="fas fa-basketball-ball"></i> {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'category_sport', 'Спорт') }} @break
                                    @case('art') <i class="fas fa-palette"></i> {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'category_art', 'Искусство') }} @break
                                    @case('science') <i class="fas fa-flask"></i> {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'category_science', 'Наука') }} @break
                                    @case('technology') <i class="fas fa-laptop-code"></i> {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'category_technology', 'Технологии') }} @break
                                    @case('music') <i class="fas fa-music"></i> {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'category_music', 'Музыка') }} @break
                                    @default <i class="fas fa-tag"></i> {{ $club['category'] }}
                                @endswitch
                            </span>
                            <span class="youth-club-badge youth-recruiting">{{ now()->year }}</span>
                        </div>
                        <h3 class="youth-club-title">{{ $club['name'] }}</h3>
                        <p>{{ $club['desc'] }}</p>
                        <div class="youth-club-info">
                            <div class="youth-info">
                                <span class="youth-info-glow">
                                    <i class="fas fa-users" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_users', 'Пользователи') }}"></i> 
                                    {{ $club['participants'] }}
                                </span>
                                <span class="youth-info-glow">
                                    <i class="fas fa-calendar-alt" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_calendar', 'Календарь') }}"></i> 
                                    {{ $club['schedule'] }}
                                </span>
                            </div>
                        </div>
                        <button class="youth-btn-club youth-btn-hover" onclick="openClubModal('{{ $club['id'] }}', '{{ $club['index'] }}')">
                            {{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'club_button_text', 'Подробнее') }} 
                            <i class="fas fa-arrow-right" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_arrow_right', 'Стрелка вправо') }}"></i>
                        </button>
                        <div class="youth-card-shine"></div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

</div>

<div id="event-modal" class="youth-modal">
    <div class="youth-modal-card">
        <div class="youth-modal-header">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-4">
                    <div class="youth-modal-number" id="event-modal-number">1</div>
                    <div class="flex-1 min-w-0">
                        <h3 class="youth-modal-title" id="event-modal-title">
                            {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_event_title', 'Детали события') }}
                        </h3>
                    </div>
                </div>
                <button type="button" class="youth-modal-close" onclick="closeModal('event')" title="{{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_close_title', 'Закрыть') }}">
                    <i class="fas fa-times text-xl" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_times', 'Закрыть') }}"></i>
                </button>
            </div>
        </div>
        <div class="youth-modal-body" id="event-modal-body">
        </div>
    </div>
</div>

<div id="club-modal" class="youth-modal">
    <div class="youth-modal-card">
        <div class="youth-modal-header">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-4">
                    <div class="youth-modal-number" id="club-modal-number">1</div>
                    <div class="flex-1 min-w-0">
                        <h3 class="youth-modal-title" id="club-modal-title">
                            {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_club_title', 'Детали направления') }}
                        </h3>
                    </div>
                </div>
                <button type="button" class="youth-modal-close" onclick="closeModal('club')" title="{{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_close_title', 'Закрыть') }}">
                    <i class="fas fa-times text-xl" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_times', 'Закрыть') }}"></i>
                </button>
            </div>
        </div>
        <div class="youth-modal-body" id="club-modal-body">
        </div>
    </div>
</div>

<div id="announcement-modal" class="youth-modal">
    <div class="youth-modal-card">
        <div class="youth-modal-header">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-4">
                    <div class="youth-modal-number">
                        <i class="fas fa-bullhorn" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_bullhorn', 'Громкоговоритель') }}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="youth-modal-title" id="announcement-modal-title">
                            {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_announcement_title', 'Объявление') }}
                        </h3>
                    </div>
                </div>
                <button type="button" class="youth-modal-close" onclick="closeModal('announcement')" title="{{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_close_title', 'Закрыть') }}">
                    <i class="fas fa-times text-xl" title="{{ \App\Models\PageSection::getValue('youth_movement', 'icons_symbols', 'icon_times', 'Закрыть') }}"></i>
                </button>
            </div>
        </div>
        <div class="youth-modal-body" id="announcement-modal-body">
        </div>
    </div>
</div>

<div id="youth-image-modal" class="youth-image-modal">
    <div class="youth-image-modal-content">
        <button type="button" class="youth-image-modal-close" title="Закрыть">
            <i class="fas fa-times" title="Закрыть"></i>
        </button>
        <img id="youth-image-modal-img" src="" alt="Изображение" class="youth-image-modal-img">
    </div>
</div>

<script>
@php
    $eventsData = [];
    
    if(isset($upcomingEvents)) {
        foreach($upcomingEvents as $event) {
            if ($event->event_date) {
                $eventDate = \Carbon\Carbon::parse($event->event_date)->setTimezone(config('app.timezone'));
                $dateStr = $eventDate->format('Y-m-d');
                
                $eventData = [
                    'id' => $event->id,
                    'title' => $event->title,
                    'date' => $dateStr,
                    'day' => $eventDate->format('j'),
                    'event_date_display' => $eventDate->toISOString(),
                    'event_date_formatted' => $eventDate->locale('ru')->translatedFormat('d F Y • H:i'),
                    'event_date_short' => $eventDate->locale('ru')->translatedFormat('d F'),
                    'event_date_time' => $eventDate->format('H:i'),
                    'location' => $event->location,
                    'organizer' => $event->organizer,
                    'type' => $event->type,
                    'description' => $event->description ?? $event->short_description,
                    'short_description' => $event->short_description,
                    'participants_count' => $event->participants_count,
                    'registration_link' => $event->registration_link
                ];
                
                if (!$event || !$event->image) {
                    $eventData['image_url'] = \App\Models\PageSection::getValue('youth_movement', 'images', 'default_event_image', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');
                } else if (strpos($event->image, 'http') === 0) {
                    $eventData['image_url'] = $event->image;
                } else if (file_exists(public_path('uploads/' . $event->image))) {
                    $eventData['image_url'] = asset('uploads/' . $event->image);
                } elseif (file_exists(storage_path('app/public/' . $event->image))) {
                    $eventData['image_url'] = asset('storage/' . $event->image);
                } else {
                    $eventData['image_url'] = \App\Models\PageSection::getValue('youth_movement', 'images', 'default_event_image', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');
                }
                
                $eventsData[$event->id] = $eventData;
            }
        }
    }
    
    if($featuredEvent && $featuredEvent->event_date) {
        $featuredEventDate = \Carbon\Carbon::parse($featuredEvent->event_date)->setTimezone(config('app.timezone'));
        $dateStr = $featuredEventDate->format('Y-m-d');
        
        $featuredEventData = [
            'id' => $featuredEvent->id,
            'title' => $featuredEvent->title,
            'date' => $dateStr,
            'day' => $featuredEventDate->format('j'),
            'event_date_display' => $featuredEventDate->toISOString(),
            'event_date_formatted' => $featuredEventDate->locale('ru')->translatedFormat('d F, H:i'),
            'event_date_short' => $featuredEventDate->locale('ru')->translatedFormat('d F'),
            'event_date_time' => $featuredEventDate->format('H:i'),
            'location' => $featuredEvent->location,
            'organizer' => $featuredEvent->organizer,
            'type' => $featuredEvent->type,
            'description' => $featuredEvent->description ?? $featuredEvent->short_description,
            'short_description' => $featuredEvent->short_description,
            'participants_count' => $featuredEvent->participants_count,
            'registration_link' => $featuredEvent->registration_link
        ];
        
        if (!$featuredEvent || !$featuredEvent->image) {
            $featuredEventData['image_url'] = \App\Models\PageSection::getValue('youth_movement', 'images', 'default_event_image', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');
        } else if (strpos($featuredEvent->image, 'http') === 0) {
            $featuredEventData['image_url'] = $featuredEvent->image;
        } else if (file_exists(public_path('uploads/' . $featuredEvent->image))) {
            $featuredEventData['image_url'] = asset('uploads/' . $featuredEvent->image);
        } elseif (file_exists(storage_path('app/public/' . $featuredEvent->image))) {
            $featuredEventData['image_url'] = asset('storage/' . $featuredEvent->image);
        } else {
            $featuredEventData['image_url'] = \App\Models\PageSection::getValue('youth_movement', 'images', 'default_event_image', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');
        }
        
        $eventsData[$featuredEvent->id] = $featuredEventData;
    }
    
    $clubsData = [];
    if(isset($clubs)) {
        foreach($clubs as $index => $club) {
            $clubData = $club->toArray();
            if (!$club || !$club->image) {
                $clubData['image_url'] = \App\Models\PageSection::getValue('youth_movement', 'images', 'default_club_image', 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');
            } else if (strpos($club->image, 'http') === 0) {
                $clubData['image_url'] = $club->image;
            } else if (file_exists(public_path('uploads/' . $club->image))) {
                $clubData['image_url'] = asset('uploads/' . $club->image);
            } elseif (file_exists(storage_path('app/public/' . $club->image))) {
                $clubData['image_url'] = asset('storage/' . $club->image);
            } else {
                $clubData['image_url'] = \App\Models\PageSection::getValue('youth_movement', 'images', 'default_club_image', 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');
            }
            $clubData['index'] = $index + 1;
            $clubData['translated_name'] = $club->getTranslatedName() ?? $club->name;
            $clubData['translated_short_description'] = $club->getTranslatedShortDescription() ?? $club->short_description;
            $clubData['translated_description'] = $club->getTranslatedDescription() ?? $club->description;
            $clubData['translated_schedule'] = $club->getTranslatedSchedule() ?? $club->schedule;
            $clubData['translated_location'] = $club->getTranslatedLocation() ?? $club->location;
            $clubData['translated_room'] = $club->getTranslatedRoom() ?? $club->room;
            $clubData['translated_instructor_name'] = $club->getTranslatedInstructorName() ?? $club->instructor_name;
            $clubData['instructor_phone'] = $club->instructor_phone ?? null;
            $clubData['instructor_email'] = $club->instructor_email ?? null;
            $clubsData[$club->id] = $clubData;
        }
    }
    
    $announcementsData = [];
    if(isset($announcements)) {
        foreach($announcements as $announcement) {
            $announcementData = $announcement->toArray();
            $announcementData['translated_title'] = $announcement->translated_title ?? $announcement->title;
            $announcementData['translated_content'] = $announcement->translated_content ?? $announcement->content;
            $announcementData['translated_action_text'] = $announcement->translated_action_text ?? $announcement->action_text;
            $announcementsData[$announcement->id] = $announcementData;
        }
    }
@endphp

const youthEvents = @json($eventsData);
const youthClubs = @json($clubsData);
const youthAnnouncements = @json($announcementsData);

const eventsByDate = {};
const eventsByMonth = {};

Object.values(youthEvents).forEach(event => {
    if (event.date) {
        const dateStr = event.date;
        if (!eventsByDate[dateStr]) {
            eventsByDate[dateStr] = [];
        }
        eventsByDate[dateStr].push(event);
        
        const monthKey = dateStr.substring(0, 7);
        if (!eventsByMonth[monthKey]) {
            eventsByMonth[monthKey] = [];
        }
        eventsByMonth[monthKey].push(event);
    }
});

let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();
let selectedDate = formatDate(currentDate);

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function getMonthName(monthIndex) {
    const months = [
        '{{ \App\Models\PageSection::getValue("youth_movement", "calendar", "month_names", "Январь,Февраль,Март,Апрель,Май,Июнь,Июль,Август,Сентябрь,Октябрь,Ноябрь,Декабрь") }}'.split(',')[0] || 'Январь',
        '{{ \App\Models\PageSection::getValue("youth_movement", "calendar", "month_names", "Январь,Февраль,Март,Апрель,Май,Июнь,Июль,Август,Сентябрь,Октябрь,Ноябрь,Декабрь") }}'.split(',')[1] || 'Февраль',
        '{{ \App\Models\PageSection::getValue("youth_movement", "calendar", "month_names", "Январь,Февраль,Март,Апрель,Май,Июнь,Июль,Август,Сентябрь,Октябрь,Ноябрь,Декабрь") }}'.split(',')[2] || 'Март',
        '{{ \App\Models\PageSection::getValue("youth_movement", "calendar", "month_names", "Январь,Февраль,Март,Апрель,Май,Июнь,Июль,Август,Сентябрь,Октябрь,Ноябрь,Декабрь") }}'.split(',')[3] || 'Апрель',
        '{{ \App\Models\PageSection::getValue("youth_movement", "calendar", "month_names", "Январь,Февраль,Март,Апрель,Май,Июнь,Июль,Август,Сентябрь,Октябрь,Ноябрь,Декабрь") }}'.split(',')[4] || 'Май',
        '{{ \App\Models\PageSection::getValue("youth_movement", "calendar", "month_names", "Январь,Февраль,Март,Апрель,Май,Июнь,Июль,Август,Сентябрь,Октябрь,Ноябрь,Декабрь") }}'.split(',')[5] || 'Июнь',
        '{{ \App\Models\PageSection::getValue("youth_movement", "calendar", "month_names", "Январь,Февраль,Март,Апрель,Май,Июнь,Июль,Август,Сентябрь,Октябрь,Ноябрь,Декабрь") }}'.split(',')[6] || 'Июль',
        '{{ \App\Models\PageSection::getValue("youth_movement", "calendar", "month_names", "Январь,Февраль,Март,Апрель,Май,Июнь,Июль,Август,Сентябрь,Октябрь,Ноябрь,Декабрь") }}'.split(',')[7] || 'Август',
        '{{ \App\Models\PageSection::getValue("youth_movement", "calendar", "month_names", "Январь,Февраль,Март,Апрель,Май,Июнь,Июль,Август,Сентябрь,Октябрь,Ноябрь,Декабрь") }}'.split(',')[8] || 'Сентябрь',
        '{{ \App\Models\PageSection::getValue("youth_movement", "calendar", "month_names", "Январь,Февраль,Март,Апрель,Май,Июнь,Июль,Август,Сентябрь,Октябрь,Ноябрь,Декабрь") }}'.split(',')[9] || 'Октябрь',
        '{{ \App\Models\PageSection::getValue("youth_movement", "calendar", "month_names", "Январь,Февраль,Март,Апрель,Май,Июнь,Июль,Август,Сентябрь,Октябрь,Ноябрь,Декабрь") }}'.split(',')[10] || 'Ноябрь',
        '{{ \App\Models\PageSection::getValue("youth_movement", "calendar", "month_names", "Январь,Февраль,Март,Апрель,Май,Июнь,Июль,Август,Сентябрь,Октябрь,Ноябрь,Декабрь") }}'.split(',')[11] || 'Декабрь'
    ];
    return months[monthIndex];
}

function updateMonthYearDisplay() {
    const monthYearElement = document.getElementById('current-month');
    const calendarMonthElement = document.getElementById('calendar-month');
    
    if (monthYearElement) {
        const monthName = getMonthName(currentMonth);
        monthYearElement.textContent = `${monthName} ${currentYear}`;
    }
    
    if (calendarMonthElement) {
        const monthName = getMonthName(currentMonth);
        calendarMonthElement.textContent = `${monthName} ${currentYear}`;
    }
}

function generateCalendar() {
    const calendarGrid = document.getElementById('calendar-grid');
    if (!calendarGrid) return;
    
    let calendarHTML = '';
    const weekdays = '{{ \App\Models\PageSection::getValue("youth_movement", "calendar", "weekdays", "Пн,Вт,Ср,Чт,Пт,Сб,Вс") }}'.split(',');
    weekdays.forEach(weekday => {
        calendarHTML += `<div class="youth-calendar-weekday">${weekday.trim()}</div>`;
    });
    
    const firstDay = new Date(currentYear, currentMonth, 1);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);
    const daysInMonth = lastDay.getDate();
    const startingDay = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1;
    
    const prevMonthLastDay = new Date(currentYear, currentMonth, 0).getDate();
    
    for (let i = 0; i < startingDay; i++) {
        const day = prevMonthLastDay - startingDay + i + 1;
        const date = new Date(currentYear, currentMonth - 1, day);
        const dateStr = formatDate(date);
        
        calendarHTML += `
            <div class="youth-calendar-day youth-calendar-other-month" 
                 data-date="${dateStr}">
                ${day}
            </div>
        `;
    }
    
    const todayStr = formatDate(new Date());
    
    for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(currentYear, currentMonth, day);
        const dateStr = formatDate(date);
        const isToday = dateStr === todayStr;
        const hasEvent = eventsByDate[dateStr] && eventsByDate[dateStr].length > 0;
        
        let dayClass = 'youth-calendar-day';
        if (isToday) dayClass += ' youth-calendar-today';
        if (hasEvent) dayClass += ' youth-calendar-event';
        
        calendarHTML += `
            <div class="${dayClass}" 
                 data-date="${dateStr}"
                 onclick="showEventsForDate('${dateStr}', this)">
                ${day}
            </div>
        `;
    }
    
    const totalCells = 42;
    const remainingCells = totalCells - (startingDay + daysInMonth);
    for (let day = 1; day <= remainingCells; day++) {
        const date = new Date(currentYear, currentMonth + 1, day);
        const dateStr = formatDate(date);
        
        calendarHTML += `
            <div class="youth-calendar-day youth-calendar-other-month" 
                 data-date="${dateStr}">
                ${day}
            </div>
        `;
    }
    
    calendarGrid.innerHTML = calendarHTML;
    updateMonthYearDisplay();
}

function changeMonth(direction) {
    currentMonth += direction;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    } else if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    
    generateCalendar();
}

function showEventsForDate(dateStr, element) {
    const eventsOnDate = eventsByDate[dateStr];
    
    if (eventsOnDate && eventsOnDate.length > 0) {
        if (eventsOnDate.length === 1) {
            openEventModal(eventsOnDate[0].id);
        } else {
            const modalBody = document.getElementById('event-modal-body');
            const modalTitle = document.getElementById('event-modal-title');
            const modalNumber = document.getElementById('event-modal-number');
            
            const dateObj = new Date(dateStr);
            modalTitle.textContent = `{{ \App\Models\PageSection::getValue('youth_movement', 'calendar', 'multiple_events_title', 'События на') }} ${dateObj.toLocaleDateString('ru-RU', {day: 'numeric', month: 'long', year: 'numeric'})}`;
            modalNumber.textContent = eventsOnDate.length;
            
            const eventsList = eventsOnDate.map(event => {
                const eventDate = event.event_date_display ? new Date(event.event_date_display) : null;
                const time = eventDate ? eventDate.toLocaleTimeString('ru-RU', {hour: '2-digit', minute:'2-digit'}) : '';
                return `<div class="youth-modal-info-item" onclick="openEventModal('${event.id}')" style="cursor: pointer;">
                    <span class="youth-modal-info-icon"><i class="fas fa-calendar-alt"></i></span>
                    <span>${event.title} ${time ? '(' + time + ')' : ''}</span>
                </div>`;
            }).join('');
            
            modalBody.innerHTML = `
                <div class="section-title">
                    <i class="fas fa-calendar-day mr-3"></i>
                    {{ \App\Models\PageSection::getValue('youth_movement', 'calendar', 'multiple_events_desc', 'На этот день запланировано') }} ${eventsOnDate.length} {{ \App\Models\PageSection::getValue('youth_movement', 'calendar', 'multiple_events_suffix', 'событий') }}
                </div>
                
                <div class="youth-modal-info">
                    ${eventsList}
                </div>
                
                <div class="youth-modal-actions">
                    <button class="youth-modal-btn-outline" onclick="closeModal('event')">
                        <i class="fas fa-times mr-3"></i>
                        {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_button_close', 'Закрыть') }}
                    </button>
                </div>
            `;
            
            openModal('event');
        }
    } else {
        alert('{{ \App\Models\PageSection::getValue("youth_movement", "calendar", "no_events_message", "На выбранную дату событий не запланировано") }}');
    }
}

function openModal(type) {
    const modal = document.getElementById(`${type}-modal`);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        document.body.style.paddingRight = window.innerWidth - document.documentElement.clientWidth + 'px';
    }
}

function closeModal(type) {
    const modal = document.getElementById(`${type}-modal`);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    }
}

function openEventModal(eventId) {
    if (eventId === '0') {
        showDemoEvent();
        return;
    }
    
    const event = youthEvents[eventId];
    if (!event) {
        showNotFound('{{ \App\Models\PageSection::getValue("youth_movement", "modal_windows", "modal_not_found_title", "Событие не найдено") }}', '{{ \App\Models\PageSection::getValue("youth_movement", "modal_windows", "modal_not_found_message", "Событие с указанным ID не найдено в загруженных данных.") }}');
        return;
    }
    
    const modalBody = document.getElementById('event-modal-body');
    const modalTitle = document.getElementById('event-modal-title');
    const modalNumber = document.getElementById('event-modal-number');
    
    modalTitle.textContent = event.title || '{{ \App\Models\PageSection::getValue("youth_movement", "modal_windows", "modal_event_title", "Детали события") }}';
    modalNumber.textContent = '1';
    
    const eventDate = event.event_date_display ? new Date(event.event_date_display) : null;
    const formattedDate = eventDate ? eventDate.toLocaleDateString('ru-RU', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }) : (event.event_date_formatted || '{{ \App\Models\PageSection::getValue("youth_movement", "carousel_events", "event_date_unknown", "Дата уточняется") }}');
    
    modalBody.innerHTML = `
        <img src="${event.image_url || '{{ \App\Models\PageSection::getValue("youth_movement", "images", "default_event_image", "https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80") }}'}" 
             alt="${event.title || 'Событие'}" 
             class="youth-modal-image" 
             onclick="openImageModal(this.src)"
             onerror="this.src='{{ \App\Models\PageSection::getValue("youth_movement", "images", "default_event_image", "https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80") }}'">
        
        <div class="youth-modal-stats">
            ${event.participants_count ? `
            <div class="youth-modal-stat">
                <div class="youth-modal-stat-value">${event.participants_count}</div>
                <div class="youth-modal-stat-label">{{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_stat_participants', 'участников') }}</div>
            </div>` : ''}
            ${eventDate ? `
            <div class="youth-modal-stat">
                <div class="youth-modal-stat-value">${eventDate.getDate()}</div>
                <div class="youth-modal-stat-label">${eventDate.toLocaleDateString('ru-RU', { month: 'long' })}</div>
            </div>` : ''}
            ${eventDate ? `
            <div class="youth-modal-stat">
                <div class="youth-modal-stat-value">${eventDate.getHours().toString().padStart(2, '0')}:${eventDate.getMinutes().toString().padStart(2, '0')}</div>
                <div class="youth-modal-stat-label">{{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_stat_time', 'время') }}</div>
            </div>` : ''}
        </div>
        
        <div class="youth-modal-info">
            ${event.location ? `<div class="youth-modal-info-item">
                <span class="youth-modal-info-icon"><i class="fas fa-map-marker-alt"></i></span>
                <span>{{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_info_location', 'Место') }}: ${event.location}</span>
            </div>` : ''}
            ${event.organizer ? `<div class="youth-modal-info-item">
                <span class="youth-modal-info-icon"><i class="fas fa-user"></i></span>
                <span>{{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_info_organizer', 'Организатор') }}: ${event.organizer}</span>
            </div>` : ''}
            ${event.type ? `<div class="youth-modal-info-item">
                <span class="youth-modal-info-icon"><i class="fas fa-bullseye"></i></span>
                <span>{{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_info_type', 'Тип') }}: ${event.type === 'week_event' ? '{{ \App\Models\PageSection::getValue("youth_movement", "modal_windows", "demo_event_type", "Главное событие") }}' : '{{ \App\Models\PageSection::getValue("youth_movement", "modal_windows", "demo_event_type_default", "Событие") }}'}</span>
            </div>` : ''}
        </div>
        
        <div class="section-title">
            <i class="fas fa-align-left mr-3"></i>
            {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_section_description', 'Описание события') }}
        </div>
        
        <div class="youth-modal-description">
            ${event.description || event.short_description || '{{ \App\Models\PageSection::getValue("youth_movement", "featured_event", "default_event_description", "Описание события") }}'}
        </div>
        
        ${event.registration_link ? `
        <div class="youth-modal-actions">
            <a href="${event.registration_link}" target="_blank" class="youth-modal-btn">
                <i class="fas fa-calendar-check mr-3"></i>
                {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_button_register', 'Зарегистрироваться') }}
            </a>
        </div>` : ''}
    `;
    
    openModal('event');
}

function openClubModal(clubId, index) {
    if (clubId === '0') {
        showDemoClub(index);
        return;
    }
    
    const club = youthClubs[clubId];
    if (!club) {
        showNotFound('{{ \App\Models\PageSection::getValue("youth_movement", "modal_windows", "modal_not_found_title", "Направление не найдено") }}', '{{ \App\Models\PageSection::getValue("youth_movement", "modal_windows", "modal_not_found_message", "Информация о направлении не доступна.") }}');
        return;
    }
    
    console.log('Club data:', club);
    
    const modalBody = document.getElementById('club-modal-body');
    const modalTitle = document.getElementById('club-modal-title');
    const modalNumber = document.getElementById('club-modal-number');
    
    modalTitle.textContent = club.translated_name || club.name || '{{ \App\Models\PageSection::getValue("youth_movement", "modal_windows", "modal_club_title", "Детали направления") }}';
    modalNumber.textContent = club.index || index || '1';
    
    modalBody.innerHTML = `
        <img src="${club.image_url || '{{ \App\Models\PageSection::getValue("youth_movement", "images", "default_club_image", "https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80") }}'}" 
             alt="${club.translated_name || club.name || 'Направление'}" 
             class="youth-modal-image" 
             onclick="openImageModal(this.src)"
             onerror="this.src='{{ \App\Models\PageSection::getValue("youth_movement", "images", "default_club_image", "https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80") }}'">
        
        <div class="service-features-grid">
            <div class="service-feature-card">
                <div class="flex items-start space-x-4">
                    <div class="service-feature-icon">
                        <i class="fas fa-users text-blue-400 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="service-feature-title">{{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'club_info_participants', 'Участников') }}</h4>
                        <p class="service-feature-text">${club.current_participants}${club.max_participants ? '/' + club.max_participants : ''}</p>
                    </div>
                </div>
            </div>
            
            ${club.translated_schedule || club.schedule ? `
            <div class="service-feature-card">
                <div class="flex items-start space-x-4">
                    <div class="service-feature-icon">
                        <i class="fas fa-calendar-alt text-blue-400 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="service-feature-title">{{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'club_info_schedule', 'Расписание') }}</h4>
                        <p class="service-feature-text">${club.translated_schedule || club.schedule}</p>
                    </div>
                </div>
            </div>` : ''}
            
            <div class="service-feature-card">
                <div class="flex items-start space-x-4">
                    <div class="service-feature-icon">
                        <i class="fas fa-money-bill-wave text-blue-400 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="service-feature-title">{{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'club_info_price', 'Стоимость') }}</h4>
                        <p class="service-feature-text">${club.price > 0 ? club.price + ' ₸' : '{{ \App\Models\PageSection::getValue("youth_movement", "clubs_directions", "club_free_price", "Бесплатно") }}'}</p>
                    </div>
                </div>
            </div>
        </div>
        
        ${club.translated_location || club.location || club.translated_room || club.room ? `
        <div class="section-title">
            <i class="fas fa-map-marker-alt mr-3"></i>
            {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_section_location', 'Место проведения') }}
        </div>
        
        <div class="youth-modal-info">
            ${club.translated_location || club.location ? `<div class="youth-modal-info-item">
                <span class="youth-modal-info-icon"><i class="fas fa-building"></i></span>
                <span>${club.translated_location || club.location}</span>
            </div>` : ''}
            ${club.translated_room || club.room ? `<div class="youth-modal-info-item">
                <span class="youth-modal-info-icon"><i class="fas fa-door-open"></i></span>
                <span>${club.translated_room || club.room}</span>
            </div>` : ''}
        </div>` : ''}
        
        ${club.instructor_name || club.instructor_phone || club.instructor_email ? `
        <div class="section-title">
            <i class="fas fa-user-tie mr-3"></i>
            {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_section_instructor', 'Руководитель') }}
        </div>
        
        ${club.instructor_photo_url ? `<img src="${club.instructor_photo_url}" alt="Руководитель" class="youth-instructor-photo">` : ''}
        
        <div class="youth-modal-info">
            ${club.instructor_name ? `<div class="youth-modal-info-item">
                <span class="youth-modal-info-icon"><i class="fas fa-user"></i></span>
                <span>${club.instructor_name}</span>
            </div>` : ''}
            ${club.instructor_phone ? `<div class="youth-modal-info-item">
                <span class="youth-modal-info-icon"><i class="fas fa-phone"></i></span>
                <span>${club.instructor_phone}</span>
            </div>` : ''}
            ${club.instructor_email ? `<div class="youth-modal-info-item">
                <span class="youth-modal-info-icon"><i class="fas fa-envelope"></i></span>
                <span>${club.instructor_email}</span>
            </div>` : ''}
        </div>` : ''}
        
        <div class="section-title">
            <i class="fas fa-align-left mr-3"></i>
            {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_section_description', 'Описание направления') }}
        </div>
        
        <div class="youth-modal-description">
            ${club.translated_description || club.description || club.translated_short_description || club.short_description || '{{ \App\Models\PageSection::getValue("youth_movement", "modal_windows", "modal_section_description", "Описание направления") }}'}
        </div>
        
        <div class="youth-modal-actions">
            <button class="youth-modal-btn-outline" onclick="closeModal('club')">
                <i class="fas fa-times mr-3"></i>
                {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_button_close', 'Закрыть') }}
            </button>
        </div>
    `;
    
    openModal('club');
}

function openAnnouncementModal(announcementId) {
    const announcement = youthAnnouncements[announcementId];
    if (!announcement) {
        showNotFound('{{ \App\Models\PageSection::getValue("youth_movement", "modal_windows", "modal_not_found_title", "Объявление не найдено") }}', '{{ \App\Models\PageSection::getValue("youth_movement", "modal_windows", "modal_not_found_message", "Информация об объявлении не доступна.") }}');
        return;
    }
    
    const modalBody = document.getElementById('announcement-modal-body');
    const modalTitle = document.getElementById('announcement-modal-title');
    
    modalTitle.textContent = announcement.translated_title || announcement.title || '{{ \App\Models\PageSection::getValue("youth_movement", "modal_windows", "modal_announcement_title", "Объявление") }}';
    
    const typeColors = {
        'info': 'linear-gradient(90deg, #3b82f6, #06b6d4)',
        'warning': 'linear-gradient(90deg, #f59e0b, #d97706)',
        'success': 'linear-gradient(90deg, #22c55e, #16a34a)',
        'danger': 'linear-gradient(90deg, #dc2626, #b91c1c)'
    };
    
    const typeIcons = {
        'info': '<i class="fas fa-bullhorn"></i>',
        'warning': '<i class="fas fa-exclamation-triangle"></i>',
        'success': '<i class="fas fa-check-circle"></i>',
        'danger': '<i class="fas fa-fire"></i>'
    };
    
    modalBody.innerHTML = `
        <div class="youth-modal-tag" style="background: ${typeColors[announcement.type] || typeColors['info']}; margin-bottom: 20px;">
            ${typeIcons[announcement.type] || '<i class="fas fa-bullhorn"></i>'} 
            ${announcement.type ? announcement.type.toUpperCase() : '{{ \App\Models\PageSection::getValue("youth_movement", "announcements", "announcement_type_default", "ОБЪЯВЛЕНИЕ") }}'}
        </div>
        
        <div class="youth-modal-info">
            <div class="youth-modal-info-item">
                <span class="youth-modal-info-icon"><i class="fas fa-calendar-alt"></i></span>
                <span>${new Date(announcement.created_at).toLocaleDateString('ru-RU')}</span>
            </div>
        </div>
        
        <div class="section-title">
            <i class="fas fa-align-left mr-3"></i>
            {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_section_content', 'Содержание') }}
        </div>
        
        <div class="youth-modal-description">
            ${announcement.translated_content || announcement.content || '{{ \App\Models\PageSection::getValue("youth_movement", "modal_windows", "modal_section_content", "Содержание объявления") }}'}
        </div>
        
        ${announcement.translated_action_text || announcement.action_text ? `
        <div class="youth-modal-actions">
            ${announcement.action_url ? `<a href="${announcement.action_url}" target="_blank" class="youth-modal-btn">
                <i class="fas fa-external-link-alt mr-3"></i>
                ${announcement.translated_action_text || announcement.action_text}
            </a>` : `<button class="youth-modal-btn">
                <i class="fas fa-check mr-3"></i>
                ${announcement.translated_action_text || announcement.action_text}
            </button>`}
        </div>` : ''}
        
        <div class="youth-modal-actions">
            <button class="youth-modal-btn-outline" onclick="closeModal('announcement')">
                <i class="fas fa-times mr-3"></i>
                {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_button_close', 'Закрыть') }}
            </button>
        </div>
    `;
    
    openModal('announcement');
}

function showDemoEvent() {
    const modalBody = document.getElementById('event-modal-body');
    const modalTitle = document.getElementById('event-modal-title');
    const modalNumber = document.getElementById('event-modal-number');
    
    modalTitle.textContent = '{{ \App\Models\PageSection::getValue("youth_movement", "modal_windows", "demo_event_title", "Ночь науки 2025") }}';
    modalNumber.textContent = '1';
    
    modalBody.innerHTML = `
        <img src="{{ \App\Models\PageSection::getValue('youth_movement', 'images', 'demo_event_image_1', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80') }}" 
             alt="{{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'demo_event_title', 'Ночь науки 2025') }}" 
             class="youth-modal-image"
             onclick="openImageModal(this.src)">
        
        <div class="youth-modal-stats">
            <div class="youth-modal-stat">
                <div class="youth-modal-stat-value">{{ \App\Models\PageSection::getValue('youth_movement', 'demo_fallback', 'demo_featured_participants', '156') }}</div>
                <div class="youth-modal-stat-label">{{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_stat_participants', 'участников') }}</div>
            </div>
            <div class="youth-modal-stat">
                <div class="youth-modal-stat-value">25</div>
                <div class="youth-modal-stat-label">ноября</div>
            </div>
            <div class="youth-modal-stat">
                <div class="youth-modal-stat-value">18:00</div>
                <div class="youth-modal-stat-label">{{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_stat_time', 'время') }}</div>
            </div>
        </div>
        
        <div class="youth-modal-info">
            <div class="youth-modal-info-item">
                <span class="youth-modal-info-icon"><i class="fas fa-map-marker-alt"></i></span>
                <span>{{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_info_location', 'Место') }}: {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'demo_event_location', 'Актовый зал') }}</span>
            </div>
            <div class="youth-modal-info-item">
                <span class="youth-modal-info-icon"><i class="fas fa-user"></i></span>
                <span>{{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_info_organizer', 'Организатор') }}: {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'demo_event_organizer', 'Оргкомитет') }}</span>
            </div>
            <div class="youth-modal-info-item">
                <span class="youth-modal-info-icon"><i class="fas fa-bullseye"></i></span>
                <span>{{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_info_type', 'Тип') }}: {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'demo_event_type', 'Главное событие') }}</span>
            </div>
        </div>
        
        <div class="section-title">
            <i class="fas fa-align-left mr-3"></i>
            {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_section_description', 'Описание события') }}
        </div>
        
        <div class="youth-modal-description">
            {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'demo_event_description', 'Главное научное событие 2025 года! Эксперименты, лекции от ведущих ученых, интерактивные зоны и научные батлы. Стань частью технологической революции!') }}
        </div>
        
        <div class="youth-modal-actions">
            <button class="youth-modal-btn">
                <i class="fas fa-calendar-check mr-3"></i>
                {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_button_register', 'Зарегистрироваться') }}
            </button>
        </div>
    `;
    
    openModal('event');
}

function showDemoClub(index) {
    const demoClubs = {
        1: {
            name: '{{ \App\Models\PageSection::getValue("youth_movement", "clubs_directions", "demo_club_1_title", "AI Лаборатория") }}',
            image: '{{ \App\Models\PageSection::getValue("youth_movement", "images", "demo_club_image_1", "https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80") }}',
            participants: '30/40',
            schedule: '{{ \App\Models\PageSection::getValue("youth_movement", "clubs_directions", "demo_club_1_schedule", "Пн/Ср 19:00") }}',
            price: '{{ \App\Models\PageSection::getValue("youth_movement", "clubs_directions", "club_free_price", "Бесплатно") }}',
            instructor_name: 'Иван Сафин',
            instructor_phone: '+7 (555) 123-45-67',
            instructor_email: 'ivan.safin@example.com',
            description: '{{ \App\Models\PageSection::getValue("youth_movement", "clubs_directions", "demo_club_1_desc", "Исследования в области искусственного интеллекта, машинного обучения и нейросетей. Практические занятия, проекты и участие в хакатонах. Открываем новые горизонты в технологиях будущего.") }}'
        },
        2: {
            name: '{{ \App\Models\PageSection::getValue("youth_movement", "clubs_directions", "demo_club_2_title", "Медиастудия") }}',
            image: '{{ \App\Models\PageSection::getValue("youth_movement", "images", "demo_club_image_2", "https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80") }}',
            participants: '25/30',
            schedule: '{{ \App\Models\PageSection::getValue("youth_movement", "clubs_directions", "demo_club_2_schedule", "Вт/Чт 18:00") }}',
            price: '{{ \App\Models\PageSection::getValue("youth_movement", "clubs_directions", "club_free_price", "Бесплатно") }}',
            instructor_name: 'Алиса Петрова',
            instructor_phone: '+7 (555) 234-56-78',
            instructor_email: 'alisa.petrova@example.com',
            description: '{{ \App\Models\PageSection::getValue("youth_movement", "clubs_directions", "demo_club_2_desc", "Создание контента, видеопроизводство, блогинг и SMM для социальных сетей. Работа с профессиональным оборудованием, монтаж и продвижение контента.") }}'
        },
        3: {
            name: '{{ \App\Models\PageSection::getValue("youth_movement", "clubs_directions", "demo_club_3_title", "Уличные виды") }}',
            image: '{{ \App\Models\PageSection::getValue("youth_movement", "images", "demo_club_image_3", "https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80") }}',
            participants: '40/50',
            schedule: '{{ \App\Models\PageSection::getValue("youth_movement", "clubs_directions", "demo_club_3_schedule", "Ежедневно") }}',
            price: '{{ \App\Models\PageSection::getValue("youth_movement", "clubs_directions", "club_free_price", "Бесплатно") }}',
            instructor_name: 'Максим Волков',
            instructor_phone: '+7 (555) 345-67-89',
            instructor_email: 'maksim.volkov@example.com',
            description: '{{ \App\Models\PageSection::getValue("youth_movement", "clubs_directions", "demo_club_3_desc", "Воркаут, скейтбординг, баскетбол и другие уличные спортивные направления. Тренировки с профессиональными тренерами, участие в турнирах и фестивалях.") }}'
        },
        4: {
            name: '{{ \App\Models\PageSection::getValue("youth_movement", "clubs_directions", "demo_club_4_title", "Исследовательский клуб") }}',
            image: '{{ \App\Models\PageSection::getValue("youth_movement", "images", "demo_club_image_4", "https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80") }}',
            participants: '35/40',
            schedule: '{{ \App\Models\PageSection::getValue("youth_movement", "clubs_directions", "demo_club_4_schedule", "Пн/Пт 17:00") }}',
            price: '{{ \App\Models\PageSection::getValue("youth_movement", "clubs_directions", "club_free_price", "Бесплатно") }}',
            instructor_name: 'Мария Соколова',
            instructor_phone: '+7 (555) 456-78-90',
            instructor_email: 'maria.sokolova@example.com',
            description: '{{ \App\Models\PageSection::getValue("youth_movement", "clubs_directions", "demo_club_4_desc", "Научные проекты, публикации и участие в конференциях по различным дисциплинам. Работа с научными руководителями, подготовка к олимпиадам и конкурсам.") }}'
        }
    };
    
    const club = demoClubs[index] || demoClubs[1];
    
    const modalBody = document.getElementById('club-modal-body');
    const modalTitle = document.getElementById('club-modal-title');
    const modalNumber = document.getElementById('club-modal-number');
    
    modalTitle.textContent = club.name;
    modalNumber.textContent = index;
    
    modalBody.innerHTML = `
        <img src="${club.image}" 
             alt="${club.name}" 
             class="youth-modal-image"
             onclick="openImageModal(this.src)">
        
        <div class="service-features-grid">
            <div class="service-feature-card">
                <div class="flex items-start space-x-4">
                    <div class="service-feature-icon">
                        <i class="fas fa-users text-blue-400 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="service-feature-title">{{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'club_info_participants', 'Участников') }}</h4>
                        <p class="service-feature-text">${club.participants}</p>
                    </div>
                </div>
            </div>
            
            <div class="service-feature-card">
                <div class="flex items-start space-x-4">
                    <div class="service-feature-icon">
                        <i class="fas fa-calendar-alt text-blue-400 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="service-feature-title">{{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'club_info_schedule', 'Расписание') }}</h4>
                        <p class="service-feature-text">${club.schedule}</p>
                    </div>
                </div>
            </div>
            
            <div class="service-feature-card">
                <div class="flex items-start space-x-4">
                    <div class="service-feature-icon">
                        <i class="fas fa-money-bill-wave text-blue-400 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="service-feature-title">{{ \App\Models\PageSection::getValue('youth_movement', 'clubs_directions', 'club_info_price', 'Стоимость') }}</h4>
                        <p class="service-feature-text">${club.price}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="section-title">
            <i class="fas fa-align-left mr-3"></i>
            {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_section_description', 'Описание направления') }}
        </div>
        
        <div class="youth-modal-description">
            ${club.description}
        </div>
        
        <div class="youth-modal-actions">
            <button class="youth-modal-btn-outline" onclick="closeModal('club')">
                <i class="fas fa-times mr-3"></i>
                {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_button_close', 'Закрыть') }}
            </button>
        </div>
    `;
    
    openModal('club');
}

function showNotFound(title, message) {
    const modalBody = document.getElementById('event-modal-body');
    const modalTitle = document.getElementById('event-modal-title');
    
    modalTitle.textContent = title;
    
    modalBody.innerHTML = `
        <div style="text-align: center; padding: 40px;">
            <div style="font-size: 3rem; margin-bottom: 20px; color: #f87171;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 style="color: #fff; margin-bottom: 20px;">${title}</h3>
            <p style="color: #9ca3af; margin-bottom: 30px;">${message}</p>
            <button class="youth-modal-btn-outline" onclick="closeModal('event')" style="margin-top: 20px;">
                <i class="fas fa-times mr-3"></i>
                {{ \App\Models\PageSection::getValue('youth_movement', 'modal_windows', 'modal_button_close', 'Закрыть') }}
            </button>
        </div>
    `;
    
    openModal('event');
}

document.addEventListener('DOMContentLoaded', function() {
    generateCalendar();
    
    const particlesContainer = document.querySelector('.youth-background-particles');
    if (particlesContainer) {
        for (let i = 0; i < 40; i++) {
            const particle = document.createElement('div');
            particle.style.position = 'absolute';
            particle.style.width = Math.random() * 3 + 1 + 'px';
            particle.style.height = particle.style.width;
            particle.style.background = `rgba(${Math.random() * 100 + 155}, ${Math.random() * 100 + 155}, 255, ${Math.random() * 0.5 + 0.1})`;
            particle.style.borderRadius = '50%';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.boxShadow = `0 0 ${Math.random() * 10 + 5}px currentColor`;
            
            const duration = Math.random() * 20 + 10;
            const delay = Math.random() * 5;
            particle.style.animation = `youth-particle-float ${duration}s ease-in-out ${delay}s infinite alternate`;
            
            particlesContainer.appendChild(particle);
        }
    }
    
    const counters = document.querySelectorAll('.youth-counter');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-count') || counter.textContent);
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const updateCounter = () => {
            current += step;
            if (current < target) {
                counter.textContent = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    observer.unobserve(counter);
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(counter);
    });
    
    window.scrollToYouthContent = function() {
        const target = document.querySelector('.youth-event-banner') || document.querySelector('.youth-events-section');
        if (target) {
            target.scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }
    };
    
    const categories = document.querySelectorAll('.youth-category');
    const clubCards = document.querySelectorAll('.youth-club-card');
    
    categories.forEach(category => {
        category.addEventListener('click', function() {
            categories.forEach(c => c.classList.remove('youth-category-active'));
            this.classList.add('youth-category-active');
            
            const selectedCategory = this.dataset.category;
            
            clubCards.forEach(card => {
                if (selectedCategory === 'all' || card.dataset.category === selectedCategory) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 10);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
    
    const searchInput = document.querySelector('.youth-search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            
            clubCards.forEach(card => {
                const title = card.querySelector('.youth-club-title').textContent.toLowerCase();
                const description = card.querySelector('p').textContent.toLowerCase();
                const category = card.querySelector('.youth-club-category').textContent.toLowerCase();
                
                if (searchTerm === '' || title.includes(searchTerm) || description.includes(searchTerm) || category.includes(searchTerm)) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 10);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    }
    
    const carousel3DContainer = document.querySelector('.youth-carousel-3d-container-wide');
    const slides = document.querySelectorAll('.youth-carousel-slide');
    const dots = document.querySelectorAll('.youth-carousel-dot');
    const prevBtn = document.querySelector('.youth-nav-prev');
    const nextBtn = document.querySelector('.youth-nav-next');
    let currentSlide = 0;
    const totalSlides = slides.length;
    let isAnimating = false;
    
    function goToSlide(slideIndex) {
        if (isAnimating || totalSlides === 0) return;
        isAnimating = true;
        
        if (slideIndex < 0) slideIndex = totalSlides - 1;
        if (slideIndex >= totalSlides) slideIndex = 0;
        
        const currentActive = document.querySelector('.youth-carousel-slide.youth-active');
        if (currentActive) {
            currentActive.classList.remove('youth-active');
            currentActive.classList.add('youth-prev');
        }
        
        slides.forEach((slide, index) => {
            slide.classList.remove('youth-active', 'youth-prev', 'youth-next');
        });
        
        slides[slideIndex].classList.add('youth-active');
        
        if (dots && dots.length > 0) {
            dots.forEach((dot, index) => {
                dot.classList.remove('youth-active');
                if (index === slideIndex) {
                    dot.classList.add('youth-active');
                }
            });
        }
        
        currentSlide = slideIndex;
        
        setTimeout(() => {
            isAnimating = false;
        }, 800);
    }
    
    function nextSlide() {
        goToSlide(currentSlide + 1);
    }
    
    function prevSlide() {
        goToSlide(currentSlide - 1);
    }
    
    if (prevBtn && nextBtn && totalSlides > 0) {
        prevBtn.addEventListener('click', prevSlide);
        nextBtn.addEventListener('click', nextSlide);
    }
    
    if (dots && dots.length > 0) {
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => goToSlide(index));
        });
    }
    
    let autoSlide;
    if (totalSlides > 1) {
        autoSlide = setInterval(nextSlide, 5000);
        
        if (carousel3DContainer) {
            carousel3DContainer.addEventListener('mouseenter', () => clearInterval(autoSlide));
            carousel3DContainer.addEventListener('mouseleave', () => autoSlide = setInterval(nextSlide, 5000));
        }
    }
    
    slides.forEach(slide => {
        slide.addEventListener('mousemove', (e) => {
            if (!slide.classList.contains('youth-active') || isAnimating) return;
            
            const rect = slide.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateY = (x - centerX) / 30;
            const rotateX = (centerY - y) / 30;
            
            slide.style.transform = `perspective(1400px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(30px)`;
        });
        
        slide.addEventListener('mouseleave', () => {
            if (!slide.classList.contains('youth-active') || isAnimating) return;
            
            slide.style.transform = 'perspective(1400px) rotateX(0) rotateY(0) translateZ(0)';
        });
    });
    
    document.querySelectorAll('.youth-modal').forEach(modal => {
        modal.addEventListener('click', function(event) {
            if (event.target === this) {
                const type = this.id.replace('-modal', '');
                closeModal(type);
            }
        });
    });
    
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal('event');
            closeModal('club');
            closeModal('announcement');
        }
    });
    
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) {
            document.body.style.paddingRight = '';
        }
    });
    
    window.changeMonth = changeMonth;
    window.showEventsForDate = showEventsForDate;
    
    // Image modal functions
    window.openImageModal = function(imageUrl) {
        const modal = document.getElementById('youth-image-modal');
        const modalImg = document.getElementById('youth-image-modal-img');
        if (modal && modalImg) {
            modalImg.src = imageUrl;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    };
    
    window.closeImageModal = function() {
        const modal = document.getElementById('youth-image-modal');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    };
    
    const imageModal = document.getElementById('youth-image-modal');
    const imageModalClose = document.querySelector('.youth-image-modal-close');
    
    if (imageModal) {
        imageModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
    }
    
    if (imageModalClose) {
        imageModalClose.addEventListener('click', closeImageModal);
    }
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
});

const style = document.createElement('style');
style.textContent = `
    @keyframes youth-particle-float {
        0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.3; }
        50% { transform: translate(${Math.random() * 100 - 50}px, ${Math.random() * 100 - 50}px) scale(${Math.random() * 0.5 + 0.8}); opacity: 0.8; }
    }
`;
document.head.appendChild(style);
</script>
@endsection