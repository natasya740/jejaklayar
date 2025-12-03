@extends('layouts.app')

@section('title', 'FAQ - Pertanyaan yang Sering Diajukan')

@push('styles')
<style>
    .faq-container {
        max-width: 900px;
        margin: 3rem auto;
        padding: 0 2rem;
    }

    .faq-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .faq-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1rem;
    }

    .faq-header p {
        font-size: 1.1rem;
        color: #6b7280;
    }

    .faq-item {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border: 1px solid #f3f4f6;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .faq-item:hover {
        box-shadow: 0 4px 12px rgba(244,180,0,0.1);
        border-color: #fcd34d;
    }

    .faq-question {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        font-size: 1.1rem;
        color: #1f2937;
    }

    .faq-icon {
        font-size: 1.2rem;
        color: #f4b400;
        transition: transform 0.3s ease;
    }

    .faq-item.active .faq-icon {
        transform: rotate(180deg);
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease, margin-top 0.4s ease;
        color: #4b5563;
        line-height: 1.7;
    }

    .faq-item.active .faq-answer {
        max-height: 500px;
        margin-top: 1rem;
    }

    .contact-cta {
        background: linear-gradient(135deg, #fcd34d 0%, #f4b400 100%);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        margin-top: 3rem;
        color: #1f2937;
    }

    .contact-cta h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .contact-cta p {
        margin-bottom: 1.5rem;
        opacity: 0.9;
    }

    .contact-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .contact-btn {
        background: white;
        color: #1f2937;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .contact-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    @media (max-width: 768px) {
        .faq-header h1 {
            font-size: 2rem;
        }
        
        .faq-container {
            padding: 0 1rem;
            margin: 2rem auto;
        }
    }
</style>
@endpush

@section('content')
<div class="faq-container">
    <div class="faq-header">
        <h1><i class="fas fa-question-circle"></i> FAQ</h1>
        <p>Pertanyaan yang Sering Diajukan</p>
    </div>

    <div class="faq-list">
        @foreach($faqs as $index => $faq)
        <div class="faq-item" data-faq="{{ $index }}">
            <div class="faq-question">
                <span>{{ $faq['question'] }}</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </div>
            <div class="faq-answer">
                {{ $faq['answer'] }}
            </div>
        </div>
        @endforeach
    </div>

    <div class="contact-cta">
        <h3>Masih Ada Pertanyaan?</h3>
        <p>Kami siap membantu Anda! Hubungi kami melalui saluran di bawah ini</p>
        <div class="contact-buttons">
            <a href="mailto:admin@jejaklayar.com" class="contact-btn">
                <i class="fas fa-envelope"></i> Email Kami
            </a>
            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Jejak%20Layar" target="_blank" class="contact-btn">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
            <a href="{{ route('panduan') }}" class="contact-btn">
                <i class="fas fa-book"></i> Panduan Kontributor
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const faqItems = document.querySelectorAll('.faq-item');
        
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            
            question.addEventListener('click', () => {
                // Toggle active class
                const isActive = item.classList.contains('active');
                
                // Close all other items
                faqItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                    }
                });
                
                // Toggle current item
                if (isActive) {
                    item.classList.remove('active');
                } else {
                    item.classList.add('active');
                }
            });
        });
    });
</script>
@endpush