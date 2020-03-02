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
        // todo move
        $APPLICATION_CONTEXT = ApplicationContext::getInstance();

        /*
         * USER
         * [user:*]
         */
        $_user  = (isset($data['user'])  and ($data['user']  instanceof User))  ? $data['user']  : $APPLICATION_CONTEXT->getCurrentUser();
        if ($_user)
            $data['user'] = $_user;

        return preg_replace_callback('/\[(.*?)\]/',function ($matches) use ($data) {
            /* extract x and y from expression [x:y] */
            $arr = explode(':', substr($matches[0], 1, -1));
            if (count($arr) === 2 && isset($data[$arr[0]]) &&
                null !== ($res = $this->computeProperty($data[$arr[0]], $arr[1]))) {
                return $res;
            }
            /* We can add more cases here */
            return $matches[0];
        }, $text);
    }

    /**
     * @param $text
     *
     * @return mixed
     */
    private function computeProperty($object, $property) {
        $pascalProperty = str_replace("_", "", ucwords($property, " /_"));
        $camelProperty = lcfirst($pascalProperty);
        $propertyAccessor = 'get' . $pascalProperty;

        if (isset($object->$property)) {
            return $object->$property;
        } elseif (isset($object->$camelProperty)) {
            return $object->$camelProperty;
        } elseif (method_exists($object, $propertyAccessor)) {
            return $object->$propertyAccessor();
        }
        return null;
    }
}
