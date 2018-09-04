RC_Pinyin
==========

## Usages
```php
RC_Pinyin::convert('今天天气不错');
# JinTianTianQiBuCuo

RC_Pinyin::convert('今天天气不错', RC_Pinyin::POLICY_SHRINK);
# jintiantianqibucuo

RC_Pinyin::convert('今天天气不错', RC_Pinyin::POLICY_SHRINK, true);
# JINTIANTIANQIBUCUO

RC_Pinyin::convert('今天天气不错', RC_Pinyin::POLICY_CAMEL);
# jinTianTianQiBuCuo

RC_Pinyin::convert('今天天气不错', RC_Pinyin::POLICY_STUDLY);
# JinTianTianQiBuCuo

RC_Pinyin::convert('今天天气不错', RC_Pinyin::POLICY_UNDERSCORE);
# jin_tian_tian_qi_bu_cuo

RC_Pinyin::convert('今天天气不错', RC_Pinyin::POLICY_BLANK);
# jin tian tian qi bu cuo

RC_Pinyin::convert('今天天气不错', RC_Pinyin::POLICY_HYPHEN);
# jin-tian-tian-qi-bu-cuo

RC_Pinyin::convert('叿吀吁吂吅', RC_Pinyin::POLICY_HYPHEN);
# hong-mie-yu-mang-song

RC_Pinyin::convert('喛喞喟喠喡喢喣', RC_Pinyin::POLICY_HYPHEN);
# he-ji-huai-chong-wei-che-xu

# first RC_Pinyin
RC_Pinyin::first('上海市');
# S

RC_Pinyin::first('China');
# C

# first each RC_Pinyin
RC_Pinyin::firstEach('上海');
# SH

RC_Pinyin::firstEach('加多宝');
# JDB

RC_Pinyin::firstEach('league of legends');
# LOL

//default
RC_Pinyin::setDefaultPolicy(RC_Pinyin::POLICY_UNDERSCORE);
RC_Pinyin::setDefaultUpperCase(true);

//PHP>=5.4 内置的方式
//@doc http://php.net/manual/en/transliterator.transliterate.php


transliterator_transliterate('Any-Latin', '凉茶我喝加多宝！还是原来的配方，还是熟悉的味道! I love JDB!')
#liáng chá wǒ hē jiā duō bǎo！ hái shì yuán lái de pèi fāng， hái shì shú xī de wèi dào! I love JDB!

transliterator_transliterate('Any-Latin;Latin-ASCII;lower()', '凉茶我喝加多宝！还是原来的配方，还是熟悉的味道! I love JDB!')
#liang cha wo he jia duo bao! hai shi yuan lai de pei fang, hai shi shu xi de wei dao! i love jdb!

transliterator_transliterate('Any-Latin;Latin-ASCII;upper()', '凉茶我喝加多宝！还是原来的配方，还是熟悉的味道! I love JDB!')
#LIANG CHA WO HE JIA DUO BAO! HAI SHI YUAN LAI DE PEI FANG, HAI SHI SHU XI DE WEI DAO! I LOVE JDB!


```

