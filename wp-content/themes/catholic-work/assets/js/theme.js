/**
 * Catholic Work Theme JavaScript
 * Handles interactive features and AJAX functionality
 */

(function($) {
    'use strict';
    
    // Initialize when document is ready
    $(document).ready(function() {
        initializeTheme();
        initializeDonationForm();
        initializeContactForm();
        initializeNewsletterForm();
        initializeScrollAnimations();
    });
    
    /**
     * Initialize core theme functionality
     */
    function initializeTheme() {
        // Smooth scrolling for anchor links
        $('a[href*="#"]').not('[href="#"]').not('[href="#0"]').click(function(event) {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && 
                location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 1000);
                }
            }
        });
        
        // Mobile menu enhancements
        $('.navbar-toggler').click(function() {
            $('body').toggleClass('mobile-menu-open');
        });
        
        // Close mobile menu when clicking outside
        $(document).click(function(event) {
            if (!$(event.target).closest('.navbar').length) {
                $('body').removeClass('mobile-menu-open');
                $('.navbar-collapse').removeClass('show');
            }
        });
        
        // Add loading states to buttons
        $(document).on('submit', 'form', function() {
            var $submitBtn = $(this).find('button[type="submit"]');
            if ($submitBtn.length) {
                var originalText = $submitBtn.html();
                $submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Processing...')
                          .prop('disabled', true);
                
                // Re-enable after 3 seconds (fallback)
                setTimeout(function() {
                    $submitBtn.html(originalText).prop('disabled', false);
                }, 3000);
            }
        });
    }
    
    /**
     * Initialize donation form functionality
     */
    function initializeDonationForm() {
        // Custom amount handling
        $('.donation-form input[name="custom_amount"]').on('input', function() {
            if ($(this).val()) {
                $('.donation-form input[name="donation_amount"]').prop('checked', false);
            }
        });
        
        // Preset amount handling
        $('.donation-form input[name="donation_amount"]').change(function() {
            $('.donation-form input[name="custom_amount"]').val('');
        });
        
        // Donation form submission
        $('.donation-form').submit(function(e) {
            e.preventDefault();
            
            var amount = $('input[name="donation_amount"]:checked').val() || 
                        $('input[name="custom_amount"]').val();
            var frequency = $('input[name="donation_frequency"]:checked').val();
            
            if (!amount || amount <= 0) {
                showNotification('Please select or enter a donation amount.', 'error');
                return;
            }
            
            // Here you would integrate with your payment processor
            // For now, just show a success message
            showNotification('Thank you for your generous donation!', 'success');
        });
    }
    
    /**
     * Initialize contact form functionality
     */
    function initializeContactForm() {
        $('.contact-form').submit(function(e) {
            e.preventDefault();
            
            var formData = {
                action: 'catholic_work_contact_form',
                name: $('input[name="contact_name"]').val(),
                email: $('input[name="contact_email"]').val(),
                subject: $('select[name="contact_subject"]').val(),
                message: $('textarea[name="contact_message"]').val(),
                newsletter: $('input[name="contact_newsletter"]').is(':checked'),
                nonce: catholic_work_ajax.nonce
            };
            
            // Basic validation
            if (!formData.name || !formData.email || !formData.message) {
                showNotification('Please fill in all required fields.', 'error');
                return;
            }
            
            // AJAX submission
            $.ajax({
                url: catholic_work_ajax.ajax_url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        showNotification('Thank you! Your message has been sent.', 'success');
                        $('.contact-form')[0].reset();
                    } else {
                        showNotification(response.data || 'There was an error sending your message.', 'error');
                    }
                },
                error: function() {
                    showNotification('There was an error sending your message. Please try again.', 'error');
                }
            });
        });
    }
    
    /**
     * Initialize newsletter form functionality
     */
    function initializeNewsletterForm() {
        $('.newsletter-form').submit(function(e) {
            e.preventDefault();
            
            var formData = {
                action: 'catholic_work_newsletter_signup',
                first_name: $('input[name="first_name"]').val(),
                email: $('input[name="email"]').val(),
                interests: $('input[name="interests[]"]:checked').map(function() {
                    return this.value;
                }).get(),
                nonce: catholic_work_ajax.nonce
            };
            
            // Basic validation
            if (!formData.first_name || !formData.email) {
                showNotification('Please enter your name and email address.', 'error');
                return;
            }
            
            // AJAX submission
            $.ajax({
                url: catholic_work_ajax.ajax_url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        showNotification('Thank you for subscribing to our newsletter!', 'success');
                        $('.newsletter-form')[0].reset();
                    } else {
                        showNotification(response.data || 'There was an error with your subscription.', 'error');
                    }
                },
                error: function() {
                    showNotification('There was an error. Please try again.', 'error');
                }
            });
        });
    }
    
    /**
     * Initialize scroll animations
     */
    function initializeScrollAnimations() {
        // Intersection Observer for fade-in animations
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });
            
            // Observe elements that should animate
            $('.course-card, .product-card, .member-card, .widget').each(function() {
                observer.observe(this);
            });
        }
        
        // Back to top button
        var $backToTop = $('<button id="back-to-top" class="btn btn-primary position-fixed" style="bottom: 20px; right: 20px; z-index: 1000; display: none;"><i class="fas fa-arrow-up"></i></button>');
        $('body').append($backToTop);
        
        $(window).scroll(function() {
            if ($(window).scrollTop() > 300) {
                $backToTop.fadeIn();
            } else {
                $backToTop.fadeOut();
            }
        });
        
        $backToTop.click(function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop: 0}, 800);
        });
    }
    
    /**
     * Show notification messages
     */
    function showNotification(message, type) {
        var alertClass = type === 'error' ? 'alert-danger' : 'alert-success';
        var icon = type === 'error' ? 'fas fa-exclamation-circle' : 'fas fa-check-circle';
        
        var notification = $('<div class="alert ' + alertClass + ' alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 1050; max-width: 400px;">' +
            '<i class="' + icon + '"></i> ' + message +
            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
            '</div>');
        
        $('body').append(notification);
        
        // Auto-remove after 5 seconds
        setTimeout(function() {
            notification.alert('close');
        }, 5000);
    }
    
    /**
     * Initialize accessibility features
     */
    function initializeAccessibility() {
        // Skip to content link
        var skipLink = $('<a href="#primary" class="skip-link sr-only">Skip to main content</a>');
        skipLink.on('focus', function() {
            $(this).removeClass('sr-only');
        }).on('blur', function() {
            $(this).addClass('sr-only');
        });
        $('body').prepend(skipLink);
        
        // Keyboard navigation for dropdowns
        $('.dropdown-toggle').on('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                $(this).dropdown('toggle');
            }
        });
        
        // Focus management for modals
        $(document).on('shown.bs.modal', '.modal', function() {
            $(this).find('[autofocus]').focus();
        });
    }
    
    // Initialize accessibility features
    initializeAccessibility();
    
    /**
     * Community component specific JavaScript
     */
    function initializeCommunityFeatures() {
        // Member directory search
        $('#member-search').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            $('.member-card').each(function() {
                var memberName = $(this).find('.member-name').text().toLowerCase();
                if (memberName.includes(searchTerm)) {
                    $(this).parent().show();
                } else {
                    $(this).parent().hide();
                }
            });
        });
        
        // Event calendar integration (placeholder)
        if ($('.community-calendar').length) {
            // Initialize calendar here when integrating with a calendar plugin
            console.log('Community calendar detected - ready for integration');
        }
    }
    
    /**
     * Learning component specific JavaScript
     */
    function initializeLearningFeatures() {
        // Course progress tracking
        $('.course-card').on('click', function() {
            var courseId = $(this).data('course-id');
            if (courseId) {
                // Track course view
                $.ajax({
                    url: catholic_work_ajax.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'track_course_view',
                        course_id: courseId,
                        nonce: catholic_work_ajax.nonce
                    }
                });
            }
        });
        
        // Learning path suggestions
        if ($('.learning-progress').length) {
            // Initialize learning recommendations
            console.log('Learning progress detected - ready for recommendations');
        }
    }
    
    // Initialize component-specific features
    initializeCommunityFeatures();
    initializeLearningFeatures();
    
})(jQuery);