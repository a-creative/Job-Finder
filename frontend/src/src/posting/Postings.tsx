import React from 'react';
import { useTranslation } from 'react-i18next';
import { Row, Col, Button } from 'react-bootstrap'
import { Link } from "react-router-dom";
import PostingsList from './PostingsList.jsx';
import { withRouter  } from "react-router-dom";

function Postings(){

  const { t } = useTranslation();

  return <Row>
  <Col>
    <Row className="mb-3">
      <Col >
        <Button as={Link} to="/postings/create">{t('Opret')}</Button>
      </Col>
    </Row>
    <Row>
      <Col>
        <PostingsList />
      </Col>
    </Row>
  </Col>
</Row>;
}

export default withRouter(Postings);