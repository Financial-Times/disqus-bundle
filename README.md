Inviqa Disqus Bundle
====================

This Bundle provides a simple Twig Extension for aiding with Disqus integration.

Integration
-----------

**WARNING**: For some reason it was required to remove the `-` from the user
_identifier_ in order that Disqus could decode the data. Use the replace
filter: `replace({'-': ''})` on the user ID below if required.

Create a Twig template as follows:

```twig
<div id="disqus_thread"></div>

<script type="text/javascript">
    var disqus_config = function () {

        {% if <the user is logged in> %}
            this.page.remote_auth_s3 = '{{ inviqa_disqus_get_remote_auth_s3(
                <userId>, 
                <username>, 
                <email>
            ) }}';
            this.page.api_key = '{{ inviqa_disqus_public_key() }}';
        {% endif %}

        this.page.url = '{{ app.request.uri }}';
        this.page.identifier = '{{ <page identifier> }}';
        this.page.title = '{{ <page title> }}';
    };

    (function() {
        var d = document, s = d.createElement('script');
        s.src = 'https://{{ inviqa_disqus_forum_name() }}.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
    })();
</script>

<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
```

Developer documentation
------------------------

https://help.disqus.com/customer/en/portal/articles/1243156-developer-documentation
