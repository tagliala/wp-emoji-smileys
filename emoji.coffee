(($) ->
  $(document).on 'click', '#emojy-smileys-show-more', (evt) ->
    evt.preventDefault()
    $('#emojy-smileys-more').toggleClass 'hide'
  $(document).on 'click', 'a[class^=emoji-]', (evt) ->
    evt.preventDefault()
    $this = $(this)
    $target = $this.closest('form').find('textarea')
    $target.val($target.val() + $this.data('code'));
    return
) jQuery
