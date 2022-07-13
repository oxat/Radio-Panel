<?php
namespace Classes;

use Vendor\Database;

class Page {

	protected $sql;
	protected $user;

	const BBCODES_OLD = [
		'~\[br\]~s',
		'~\[h1\](.*?)\[/h1\]~s',
		'~\[h2\](.*?)\[/h2\]~s',
		'~\[h3\](.*?)\[/h3\]~s',
		'~\[h4\](.*?)\[/h4\]~s',
		'~\[h5\](.*?)\[/h5\]~s',
		'~\[b\](.*?)\[/b\]~s',
		'~\[i\](.*?)\[/i\]~s',
		'~\[u\](.*?)\[/u\]~s',
		'~\[quote\](.*?)\[/quote\]~s',
		'~\[size=(.*?)\](.*?)\[/size\]~s',
		'~\[color=(.*?)\](.*?)\[/color\]~s',
		'~\[url\]((?:ftp|https?)://.*?)\[/url\]~s',
		'~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s',
	];

	const BBCODES_NEW = [
		'<br />',
		'<h1>$1</h1>',
		'<h2>$1</h2>',
		'<h3>$1</h3>',
		'<h4>$1</h4>',
		'<h5>$1</h5>',
		'<b>$1</b>',
		'<i>$1</i>',
		'<span style="text-decoration:underline;">$1</span>',
		'<pre>$1</'.'pre>',
		'<span style="font-size: $1px;">$2</span>',
		'<span style="color: $1;">$2</span>',
		'<a href="$1">$1</a>',
		'<img src="$1" alt="$1" />',
	];

	public function __construct() {
		$this->sql = new Database();
		$this->user = new Admin();
	}

	 public function getByStream(string $slug): array {
		return $this->sql->fetch_array("SELECT * FROM servers WHERE portbase = '{$slug}';");
	}

	public function parseBBcodes(string $html): string {
		$html = str_replace('<?php', '<?php ', $html);
		$html = preg_replace_callback('#\[code](.*?)\[\/code]#is',
			function ($matches) {
				if ($this->user->getConfig('highlight') === '1') {
					return '<pre>' . highlight_string($matches[1], true) . '</pre>';
				} else {
					return '<br /><pre><code>' . nl2br(htmlspecialchars($matches[1])) . '</code></pre>';
				}
			},
			$html
		);
		$html = preg_replace(self::BBCODES_OLD, self::BBCODES_NEW, $html);
		return $html;
	}
}
