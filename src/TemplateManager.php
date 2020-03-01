<?php

class TemplateManager
{
    public function getTemplateComputed(Template $tpl, array $data)
    {
        if (!$tpl) {
            throw new \RuntimeException('no tpl given');
        }

        $replaced = clone($tpl);
        $replaced->setSubject($this->computeText($replaced->getSubject(), $data));
        $replaced->setContent($this->computeText($replaced->getContent(), $data));

        return $replaced;
    }

    private function computeText($text, array $data)
    {
        $APPLICATION_CONTEXT = ApplicationContext::getInstance();

        /** @var QuoteViewModel|null $quote */
        $quote = (isset($data['quote']) and $data['quote'] instanceof QuoteViewModel) ? $data['quote'] : null;

        if ($quote)
        {
            $containsSummaryHtml = strpos($text, '[quote:summary_html]');
            $containsSummary     = strpos($text, '[quote:summary]');

            if ($containsSummaryHtml !== false || $containsSummary !== false) {
                if ($containsSummaryHtml !== false) {
                    $text = str_replace(
                        '[quote:summary_html]',
                        $quote->summaryHtml,
                        $text
                    );
                }
                if ($containsSummary !== false) {
                    $text = str_replace(
                        '[quote:summary]',
                        $quote->summary,
                        $text
                    );
                }
            }

            (strpos($text, '[quote:destination_name]') !== false) and
            $text = str_replace('[quote:destination_name]', $quote->destinationName,$text);
        }

        if (strpos($text, '[quote:destination_link]') !== false)
            $text = str_replace('[quote:destination_link]', $quote->destinationLink, $text);
        else
            $text = str_replace('[quote:destination_link]', '', $text);

        /*
         * USER
         * [user:*]
         */
        $_user  = (isset($data['user'])  and ($data['user']  instanceof User))  ? $data['user']  : $APPLICATION_CONTEXT->getCurrentUser();
        if($_user) {
            (strpos($text, '[user:first_name]') !== false) and $text = str_replace('[user:first_name]'       , ucfirst(mb_strtolower($_user->getFirstname())), $text);
        }

        return $text;
    }
}
