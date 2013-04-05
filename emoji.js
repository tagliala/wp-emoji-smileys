(function($) {
  $(document).on('click', '#emojy-smileys-show-more', function(evt) {
    evt.preventDefault();
    return $('#emojy-smileys-more').toggleClass('hide');
  });
  return $(document).on('click', 'a[class^=emoji-]', function(evt) {
    var $target, $this;

    evt.preventDefault();
    $this = $(this);
    $target = $this.closest('form').find('textarea');
    $target.val($target.val() + $this.data('code'));
  });
})(jQuery);
