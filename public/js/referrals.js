$(document).ready(function() {
    $('#copyReferralBtn').on('click', function() {
        const copyText = document.getElementById("referralLink");
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        
        try {
            // Modern approach - Clipboard API
            navigator.clipboard.writeText(copyText.value).then(() => {
                showCopySuccess();
            }).catch(() => {
                // Fallback to older method if Clipboard API fails
                document.execCommand("copy");
                showCopySuccess();
            });
        } catch (err) {
            console.error('Failed to copy text: ', err);
            toastr.error('Failed to copy referral link. Please try selecting and copying manually.');
        }
    });

    function showCopySuccess() {
        const $button = $('#copyReferralBtn');
        const originalHtml = $button.html();
        
        $button.html('<i class="bi bi-check"></i> Copied!');
        $button.removeClass('btn-primary').addClass('btn-success');
        
        setTimeout(() => {
            $button.html(originalHtml);
            $button.removeClass('btn-success').addClass('btn-primary');
        }, 1000);

        // Show success message using toastr
        toastr.success('Referral link copied to clipboard!');
    }
});