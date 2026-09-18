import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/Filament/**/*.php',
        './vendor/filament/**/*.blade.php',
    ],
    
    safelist: [
        // Фоновые цвета
        'bg-blue-50',
        'bg-blue-100',
        'bg-green-50',
        'bg-green-100',
        'bg-red-50',
        'bg-red-100',
        'bg-yellow-50',
        'bg-yellow-100',
        'bg-purple-50',
        'bg-purple-100',
        'bg-orange-50',
        'bg-orange-100',
        'bg-pink-50',
        'bg-pink-100',
        'bg-gray-50',
        'bg-gray-100',
        
        // Цвета текста
        'text-blue-600',
        'text-blue-700',
        'text-green-600',
        'text-green-700',
        'text-red-600',
        'text-red-700',
        'text-yellow-600',
        'text-yellow-700',
        'text-purple-600',
        'text-purple-700',
        'text-orange-600',
        'text-orange-700',
        'text-pink-600',
        'text-pink-700',
        'text-gray-600',
        'text-gray-700',
        
        // Градиенты
        'bg-gradient-to-br',
        'from-blue-50',
        'to-blue-100',
        'from-green-50',
        'to-green-100',
        'from-red-50',
        'to-red-100',
        'from-pink-50',
        'to-pink-100',
        'from-purple-50',
        'to-purple-100',
        'from-orange-50',
        'to-orange-100',
        'from-yellow-50',
        'to-yellow-100',
        'from-gray-50',
        'to-gray-100',
        
        // Границы
        'border-blue-200',
        'border-green-200',
        'border-red-200',
        'border-yellow-200',
        'border-purple-200',
        'border-orange-200',
        'border-pink-200',
        'border-gray-200',
        
        // Точки (dots)
        'bg-blue-600',
        'bg-green-600',
        'bg-red-600',
        'bg-yellow-600',
        'bg-purple-600',
        'bg-orange-600',
        'bg-pink-600',
        'bg-gray-600',
        
        // Условные классы для метаданных
        'text-green-600',
        'text-red-600',
    ],
    
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                },
            },
        },
        container: {
            center: true,
            padding: {
                DEFAULT: '1rem',
                sm: '2rem',
                lg: '4rem',
                xl: '5rem',
                '2xl': '6rem',
            },
        },
    },
    plugins: [],
};